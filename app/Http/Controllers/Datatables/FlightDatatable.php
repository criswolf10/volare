<?php

namespace App\Http\Controllers\Datatables;

use App\Models\Flight;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FlightDatatable
{


    public function getFlightData(Request $request)
    {
        $user = auth()->user();

        if ($request->ajax()) {
            // Consulta inicial para incluir relaciones
            $query = Flight::with(['aircraft:id,name,seats,status', 'tickets:id,price,seat', 'media']);

            // Si el usuario no es admin, filtrar por estado "en espera"
            if (!$user || !$user->hasRole('admin')) {
                $query->whereHas('aircraft', function ($q) {
                    $q->where('status', 'en espera');
                });
            }

            // Devuelve datos formateados para DataTables
            return DataTables::of($query)
                ->addColumn('image', function ($flight) {
                    // Obtener la URL de la imagen asociada al vuelo
                    $media = $flight->getFirstMedia('flight_images');
                    $imageUrl = $media ? $media->getUrl() : asset('icons/flights.svg'); // Imagen predeterminada si no tiene una

                    // Mostrar la imagen al lado del código del vuelo
                    return '<img src="' . $imageUrl . '" alt="Imagen de vuelo" style="width: 30px; height: auto; margin-right: 10px;">';
                })
                ->addColumn('aircraft', function ($flight) {
                    return $flight->aircraft->name ?? 'N/A'; // Mostrar el nombre del avión o "N/A" si no hay avión
                })
                ->addColumn('price', function ($flight) {
                    // Mostrar el precio del primer ticket en formato de euros
                    $price = $flight->tickets->isNotEmpty()
                        ? $flight->tickets->first()->price
                        : 0;
                    return $price % 1 == 0
                        ? number_format($price, 0, ',', '.') . '€' // Sin decimales si es un número entero
                        : number_format($price, 2, ',', '.') . '€'; // Con decimales si es un número flotante
                })
                ->addColumn('seats', function ($flight) {
                    // Decodificar el JSON para obtener un array
                    $seats = json_decode($flight->aircraft->seats, true);

                    // Verificar si el JSON fue decodificado correctamente
                    if (is_array($seats)) {
                        // Filtrar solo las claves (nombres de las clases)
                        $classes = array_keys($seats);

                        // Unir las clases en una cadena separada por comas
                        return implode(', ', $classes);
                    }

                    // Si no se puede decodificar o no hay clases, retornar 'N/A'
                    return 'N/A';
                })

                ->addColumn('departure_date', function ($flight) {
                    // Formatear la fecha de salida en d/m/y
                    return Carbon::parse($flight->departure_date)->format('d/m/Y');
                })
                ->addColumn('duration', function ($flight) {
                    // Parsear el tiempo (tipo TIME) usando Carbon
                    $time = Carbon::parse($flight->departure_time);

                    // Si la hora es "00:00:00", mostrar un valor por defecto
                    if ($time->hour == 0 && $time->minute == 0) {
                        return 'Hora no válida'; // Si la hora es "00:00:00"
                    }

                    // Convertir la hora a formato "X h Y min"
                    $hours = $time->hour;
                    $minutes = $time->minute;

                    // Si la hora y los minutos son 0, mostrar un mensaje adecuado
                    if ($hours == 0) {
                        return "{$minutes} min"; // Si solo hay minutos
                    }

                    return "{$hours} h {$minutes} min"; // Si hay horas y minutos
                })
                ->addColumn('status', function ($flight) use ($user) {
                    // Solo añadir columna 'status' si el usuario es admin
                    if ($user && $user->hasRole('admin')) {
                        $status = $flight->aircraft ? $flight->aircraft->status : 'N/A';
                        $statusColor = match ($status) {
                            'borrador' => '#6c757d',
                            'en espera' => '#ffc107',
                            'en trayecto' => '#17a2b8',
                            'completo' => '#28a745',
                            default => '#f8f9fa',
                        };

                        return "<div style='background-color: {$statusColor}; color: white; padding: 3px 7px; border-radius: 5px; font-size: 0.75rem; text-align: center;'>" . ucfirst($status) . "</div>";
                    }
                    return null; // Devuelve null si no es admin
                })

                ->addColumn('action', function ($flight) {
                    $user = auth()->user();

                    // Botones para administradores
                    if ($user && $user->hasRole('admin')) {
                        $editButton = '<a href="' . route('edit.flights', ['id' => $flight->id]) . '" class="btn btn-sm btn-info mx-2">
                                        <img src="' . asset('icons/edit.png') . '" alt="edit">
                                    </a>';

                        $deleteButton = '<button class="btn btn-sm btn-danger"
                            x-data="{}"
                            x-on:click.prevent="$dispatch(\'flight-deletion\', { flightId: ' . $flight->id . ' })">
                            <img src="' . asset('icons/cancel.png') . '" alt="delete">
                        </button>';

                        return '<div id="action-btn" class="flex gap-3">' . $editButton . $deleteButton . '</div>';
                    }

                    // Botones para clientes autenticados
                    if ($user && $user->hasRole('client')) {
                        $buyButton = '<a href="' . route('tickets.create', ['id' => $flight->id]) . '" class="btn btn-sm btn-primary">
                                        <img src="' . asset('icons/shop.png') . '" alt="buy">
                                    </a>';
                        return '<div id="action-btn" class="flex gap-3">' . $buyButton . '</div>';
                    }

                    // Botón para usuarios no autenticados
                    if (!$user) {
                        $buyButton = '<a href="' . route('tickets.create', ['id' => $flight->id]) . '" class="btn btn-sm btn-primary">
                                        <img src="' . asset('icons/shop.png') . '" alt="buy">
                                    </a>';
                        return '<div id="action-btn" class="flex gap-3">' . $buyButton . '</div>';
                    }

                    // Si no se cumple ninguna condición (esto no debería ocurrir)
                    return '';
                })


                ->rawColumns(['action', 'status', 'image']) // Permite HTML en la columna de acción
                ->make(true);
        }
    }
}
