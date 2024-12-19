<?php

namespace App\Http\Controllers\Datatables;

use App\Models\Flight;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FlightsDatatable
{


    public function getFlightData(Request $request)
    {
        $user = auth()->user();

        if ($request->ajax()) {
            // Consulta inicial para incluir relaciones
            $query = Flight::with(['aircraft:id,name,status', 'aircraft.seats', 'media']);

            // Si el usuario no es admin, filtrar por estado "en espera"
            if (!$user || !$user->hasRole('admin')) {
                $query->whereHas('aircraft', function ($q) {
                    $q->where('status', 'en espera');
                });
            }

            // Devuelve datos formateados para DataTables
            return DataTables::of($query)
                ->addColumn('image', function ($flight) {
                    $media = $flight->getFirstMedia('flight_images');
                    $imageUrl = $media ? $media->getUrl() : asset('icons/flights.svg');

                    return '<img src="' . $imageUrl . '" alt="Imagen de vuelo" style="width: 30px; height: auto; margin-right: 10px;">';
                })

                ->addColumn('aircraft', function ($flight) {
                    return $flight->aircraft->name ?? 'N/A';
                })
                ->addColumn('price', function ($flight) {
                    // Obtener el precio mínimo entre todos los asientos del avión
                    $minPrice = $flight->aircraft->seats()
                        ->min('price');

                    if ($minPrice) {
                        return 'Desde ' . number_format($minPrice, 2, ',', '.') . '€';
                    }
                    return 'N/A';
                })


                ->addColumn('seats', function ($flight) {
                    // Obtener las clases de todos los asientos del avión
                    $seatClasses = $flight->aircraft->seats()
                        ->distinct()
                        ->pluck('class')
                        ->toArray();

                    return implode(', ', $seatClasses) ?: 'N/A';
                })


                ->addColumn('departure_date', function ($flight) {
                    return Carbon::parse($flight->departure_date)->format('d/m/Y');
                })

                ->addColumn('duration', function ($flight) {
                    $duration = Carbon::createFromFormat('H:i:s', $flight->duration);
                    $hours = $duration->hour;
                    $minutes = $duration->minute;

                    return $hours > 0 ? "{$hours} h {$minutes} min" : "{$minutes} min";
                })

                ->addColumn('status', function ($flight) use ($user) {
                    if ($user && $user->hasRole('admin')) {
                        $status = $flight->aircraft->status ?? 'N/A';
                        $statusColor = match ($status) {
                            'borrador' => '#6c757d',
                            'en espera' => '#ffc107',
                            'en trayecto' => '#17a2b8',
                            'completo' => '#28a745',
                            'finalizado' => '#ff0000',
                            default => '#ff0000',
                        };

                        return "<div style='background-color: {$statusColor}; color: white; padding: 3px 7px; border-radius: 5px; font-size: 0.75rem; text-align: center;'>" . ucfirst($status) . "</div>";
                    }
                    return null;
                })

                ->addColumn('action', function ($flight) {
                    $user = auth()->user();

                    if ($user && $user->hasRole('admin')) {
                        $editButton = '<a href="' . route('edit.flights', ['id' => $flight->id]) . '" class="btn btn-sm btn-info mx-2">
                                        <img src="' . asset('icons/edit.png') . '" alt="edit">
                                    </a>';

                        $deleteButton = '<button class="btn btn-sm btn-danger"
                            x-data="{}"
                            x-on:click.prevent="$dispatch(\'flight-deletion\', { flightId: ' . $flight->id . ' })">
                            <img src="' . asset('icons/cancel.png') . '" alt="delete">
                        </button>';

                        return '<div id="action-btn" class="flex items-center justify-center">' . $editButton . $deleteButton . '</div>';
                    }

                    // Botón de compra para clientes autenticados
                    if ($user && $user->hasRole('client')) {
                        $buyButton = '<a href="' . route('tickets.purchase', ['flightId' => $flight->id]) . '" class="btn btn-sm btn-primary">
                        <img src="' . asset('icons/shop.png') . '" alt="buy">
                    </a>';
                        return '<div id="action-btn" class="flex gap-3">' . $buyButton . '</div>';
                    }

                    // Botón de compra para usuarios no autenticados
                    if (!$user) {
                        $buyButton = '<a href="' . route('tickets.purchase', ['flightId' => $flight->id]) . '" class="btn btn-sm btn-primary">
                        <img src="' . asset('icons/shop.png') . '" alt="buy">
                    </a>';
                        return '<div id="action-btn" class="flex items-center justify-center">' . $buyButton . '</div>';
                    }

                    return '';
                })

                ->rawColumns(['action', 'status', 'image'])
                ->make(true);
        }
    }
}
