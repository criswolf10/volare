<?php

namespace App\Http\Controllers;


use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class FlightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('flights');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {

        // Validar los datos del formulario
        $request->validate([
            'code' => 'required|string|max:5|unique:flights,code',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'duration' => 'required|date_format:H:i',
            'departure_date' => 'required|date',
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i',
            'status' => ['required', Rule::in(['borrador', 'en espera', 'en trayecto', 'completo', 'cancelado'])],
            'aircraft_id' => 'required|exists:aircrafts,id',
        ]);

        // Crear un nuevo vuelo con los datos validados
        $flight = Flight::create($request->all());

        // Asignar la imagen por defecto al vuelo
        $defaultImageUrl = 'icons/flights.svg';
        $flight->addMedia(public_path($defaultImageUrl))
            ->preservingOriginal()
            ->usingFileName('flights.png') // Nombre de la imagen
            ->toMediaCollection('flight_images'); // Nombre de la colección

        // Redireccionar a la vista de vuelos con un mensaje
        return redirect()->route('flights')->with('success', '¡Vuelo creado correctamente!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Flight $flight) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Flight $flight) {}


    public function getFlightData(Request $request)
    {
        if ($request->ajax()) {
            // Consulta inicial para incluir relaciones
            $query = Flight::with(['aircraft:id,name,code,seat_classes', 'tickets:id,flight_id,price', 'media']);

            // Devuelve datos formateados para DataTables
            return DataTables::of($query)
            ->addColumn('image', function ($flight) {
                // Obtener la URL de la imagen asociada al vuelo
                $media = $flight->getFirstMedia('flight_images');
                $imageUrl = $media ? $media->getUrl() : asset('icons/flights.svg'); // Imagen predeterminada si no tiene una

                // Mostrar la imagen al lado del código del vuelo
                return '<img src="' . $imageUrl . '" alt="Imagen de vuelo" style="width: 30px; height: auto; margin-right: 10px;">' ;
            })
                ->addColumn('aircraft', function ($flight) {
                    return $flight->aircraft
                        ? "{$flight->aircraft->name} - {$flight->aircraft->code}"
                        : 'N/A';
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
                ->addColumn('seat_classes', function ($flight) {
                    $seatClasses = json_decode($flight->aircraft->seat_classes, true);
                    return $seatClasses ? implode(', ', $seatClasses) : 'N/A';
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
                ->addColumn('status', function ($flight) {
                    $status = $flight->status;
                    $statusColor = '';

                    // Asignar colores según el estado
                    switch ($status) {
                        case 'borrador':
                            $statusColor = '#6c757d'; // Gris
                            break;
                        case 'en espera':
                            $statusColor = '#ffc107'; // Amarillo
                            break;
                        case 'en trayecto':
                            $statusColor = '#17a2b8'; // Azul
                            break;
                        case 'completo':
                            $statusColor = '#28a745'; // Verde
                            break;
                        case 'cancelado':
                            $statusColor = '#dc3545'; // Rojo
                            break;
                    }

                    // Retornar el estado con el color de fondo aplicado directamente
                    return "<div style='background-color: {$statusColor}; color: white; padding: 3px 7px; border-radius: 5px; font-size: 0.75rem; text-align: center;'>" . ucfirst($status) . "</div>";
                })
                ->addColumn('action', function ($row) {
                    return '<a href="#" class="btn btn-sm btn-primary edit">Editar</a>
                            <a href="#" class="btn btn-sm btn-danger delete">Eliminar</a>';
                })
                ->rawColumns(['action', 'status', 'image']) // Permite HTML en la columna de acción
                ->make(true);
        }
    }
}
