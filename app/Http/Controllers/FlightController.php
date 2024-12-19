<?php

namespace App\Http\Controllers;

use App\Http\Requests\FlightRequest;
use App\Http\Requests\UserDeleteRequest;
use App\Http\Requests\FlightUpdateRequest;
use App\Mail\FlightCancelled;
use App\Mail\FlightUpdatedNotification;
use App\Models\AircraftSeat;
use App\Models\Flight;
use App\Models\Aircraft;
use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;




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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener los aviones disponibles que solo estén en estado "borrador"
        $aircrafts = Aircraft::with('seats')->where('status', 'borrador')->get();

        // Para cada avión, obtener las clases y precios únicos
        foreach ($aircrafts as $aircraft) {
            $uniqueSeats = $aircraft->seats->unique('class');

            // Obtener las clases y precios de manera única
            $aircraft->unique_classes = $uniqueSeats->pluck('class')->toArray();
            $aircraft->unique_prices = $uniqueSeats->pluck('price')->map(function ($price) {
                return intval($price) . '€'; // Convertir a número entero y añadir el símbolo €
            })->toArray();
        }

        // Pasamos los aviones con las clases y precios únicos al formulario
        return view('admin.create-flights', compact('aircrafts'));
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(FlightRequest $request)
    {
        // Obtener el avión seleccionado
        $aircraft = Aircraft::findOrFail($request->aircraft_id);

        // Cambiar el estado del avión a "en espera" si está en borrador
        if ($aircraft->status === 'borrador') {
            $aircraft->update(['status' => 'en espera']);
        }

        // Calcular la duración
        $departureDateTime = Carbon::parse($request->departure_date . ' ' . $request->departure_time);
        $arrivalDateTime = Carbon::parse($request->departure_date . ' ' . $request->arrival_time);

        // Validar que la hora de llegada sea posterior a la hora de salida
        if ($arrivalDateTime->lt($departureDateTime)) {
            return back()->withErrors(['arrival_time' => 'La hora de llegada debe ser posterior a la hora de salida.']);
        }

        $durationInMinutes = $departureDateTime->diffInMinutes($arrivalDateTime);

        // Convertir la duración en formato "HH:MM:SS"
        $hours = intdiv($durationInMinutes, 60);
        $minutes = $durationInMinutes % 60;
        $durationTime = sprintf('%02d:%02d:00', $hours, $minutes); // Formato "HH:MM:SS"

        // Crear el vuelo con el id del avión seleccionado
        $flight = Flight::create([
            'code' => $request->code,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'departure_date' => Carbon::parse($request->departure_date)->format('Y-m-d'),
            'departure_time' => Carbon::parse($request->departure_time)->format('H:i:s'),
            'arrival_time' => Carbon::parse($request->arrival_time)->format('H:i:s'),
            'duration' => $durationTime, // Guardar la duración correctamente formateada
            'aircraft_id' => $request->aircraft_id, // Guardar el id del avión seleccionado
        ]);

        // Verificar si la hora de salida ya pasó para cambiar el estado a "en trayecto"
        $now = Carbon::now();
        if ($now->greaterThanOrEqualTo($departureDateTime)) {
            // Si la hora actual es mayor o igual a la hora de salida, cambia el estado a "en trayecto"
            $aircraft->update(['status' => 'en trayecto']);
        }

        // Redirigir o devolver la respuesta
        return redirect()->route('flights.create')->with('success', 'Vuelo creado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    // Función para mostrar el formulario de edición
    public function edit($id)
    {
        // Obtener el vuelo específico con sus tickets relacionados y el avión
        $flight = Flight::with('tickets', 'aircraft')->findOrFail($id);


        // Obtener aviones en estado "borrador" para el select
        $aircrafts = Aircraft::where('status', 'borrador')->get();

        // Pasar los datos del vuelo y tickets a la vista
        return view('admin.edit-flights', compact('flight', 'aircrafts'));
    }



    /**
     * Update the specified resource in storage.
     */
    // Función para actualizar el vuelo
    public function update(FlightUpdateRequest $request, $id)
    {
        // Obtener el vuelo específico
        $flight = Flight::findOrFail($id);

        // Comparar los valores actuales con los nuevos (usando Carbon para comparación precisa)
        $departureDateChanged = $flight->departure_date !== $request->input('departure_date');
        $departureTimeChanged = !Carbon::parse($flight->departure_time)->equalTo(Carbon::parse($request->input('departure_time')));
        $arrivalTimeChanged = !Carbon::parse($flight->arrival_time)->equalTo(Carbon::parse($request->input('arrival_time')));

        // Si al menos uno de los campos ha cambiado, actualizar y enviar notificaciones
        if ($departureDateChanged || $departureTimeChanged || $arrivalTimeChanged) {
            // Actualizar los datos del vuelo
            $flight->update([
                'departure_date' => $request->input('departure_date'),
                'departure_time' => Carbon::parse($request->input('departure_time'))->format('H:i'),
                'arrival_time' => Carbon::parse($request->input('arrival_time'))->format('H:i'),
            ]);

            // Calcular la duración en minutos
            $departureTime = Carbon::parse($request->input('departure_time'));
            $arrivalTime = Carbon::parse($request->input('arrival_time'));
            $durationInMinutes = $departureTime->diffInMinutes($arrivalTime);

            // Convertir minutos al formato HH:mm:ss
            $hours = floor($durationInMinutes / 60);
            $minutes = $durationInMinutes % 60;
            $flight->duration = sprintf('%02d:%02d:%02d', $hours, $minutes, 0); // Formato HH:mm:ss

            // Guardar los cambios
            $flight->save();

            // Enviar correos a los usuarios con tickets relacionados
            $tickets = Ticket::where('flight_id', $flight->id)->get();

            foreach ($tickets as $ticket) {
                $user = $ticket->user; // Suponiendo relación user en Ticket

                // Enviar notificación
                Mail::to($user->email)->send(new FlightUpdatedNotification($flight, $user));
            }

            // Redirigir con mensaje de éxito
            return redirect()->route('flights')->with('success_updated_flight_notificacion', 'Vuelo actualizado correctamente y se ha notificado a los usuarios con los cambios del vuelo.');
        }

        // Si no hubo cambios, redirigir con mensaje de información
        return redirect()->route('flights')->with('success_updated_flight', 'No se realizaron cambios en el vuelo, por lo tanto no se enviaron notificaciones.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserDeleteRequest $request, $id)
    {
        // Obtener el usuario administrador autenticado
        $adminUser = Auth::user();

        // Verificar que la contraseña del administrador es correcta
        $request->validate([
            'password' => ['required', function ($attribute, $value, $fail) use ($adminUser) {
                if (!Hash::check($value, $adminUser->password)) {
                    return $fail('La contraseña ingresada no es correcta.');
                }
            }],
        ]);

        // Buscar el vuelo por ID
        $flight = Flight::findOrFail($id);

        // Verificar el estado del avión asignado al vuelo
        if (!$flight->aircraft || !in_array($flight->aircraft->status, ['en espera', 'borrador', 'completo'])) {
            return redirect()->back()
                ->with('error', 'El vuelo no puede ser eliminado porque el avión asignado está en trayecto.');
        }

        // Enviar correos a los usuarios relacionados con el vuelo (solo si hay un usuario)
        foreach ($flight->tickets as $ticket) {
            $user = $ticket->user; // Obtener el usuario relacionado con el ticket

            // Verificar que el ticket tiene un usuario asociado
            if ($user) {
                Mail::to($user->email)->send(new FlightCancelled($flight, $user));
            }
        }

        // Eliminar los tickets asociados al vuelo
        $flight->tickets()->delete();

        // Eliminar el vuelo
        $flight->delete();

        // Redirigir con mensaje de éxito
        return redirect()
            ->route('flights')
            ->with('success_cancelled', 'Vuelo eliminado correctamente.');
    }




    public function dashboard()
    {
        $user = auth()->user();
        // Datos para clientes: Últimos vuelos cuyo avión tiene el estado "en espera" y tienen asientos disponibles (máximo 4)
        $latestFlights = Flight::whereHas('aircraft', function ($query) {
            $query->where('status', 'en espera');  // Filtra solo los aviones con estado "en espera"
        })
            ->where(function ($query) {
                $query->whereRaw('(SELECT COUNT(*) FROM tickets WHERE flight_id = flights.id AND status = "en espera") < flights.capacity')  // Verifica que hay asientos disponibles
                    ->orWhereRaw('(SELECT COUNT(*) FROM tickets WHERE flight_id = flights.id) < flights.capacity');  // O permite vuelos con menos asientos ocupados
            })
            ->latest()  // Ordena por la fecha de creación más reciente
            ->take(4)   // Limita a los últimos 4 vuelos
            ->get();
        // Datos para administradores: Vuelos con más plazas vacantes
        $flightsWithVacancies = Flight::withCount(['tickets as seats_taken' => function ($query) {
            $query->where('status', 'en espera');
        }])
            ->get()
            ->map(function ($flight) {
                $flight->seats_free = $flight->capacity - $flight->seats_taken;
                $flight->free_percentage = $flight->capacity > 0
                    ? round(($flight->seats_free / $flight->capacity) * 100)
                    : 0;
                return $flight;
            })
            ->sortByDesc('seats_free')
            ->take(5);

        return view('dashboard', compact('latestFlights', 'flightsWithVacancies'));
    }

    public function updateAircraftStatus()
    {
        $currentDate = Carbon::now()->toDateString(); // Fecha actual
        $currentTime = Carbon::now(); // Fecha y hora actual

        // Filtrar vuelos con fecha de salida igual a la actual
        $flights = Flight::with('aircraft')
            ->where('departure_date', $currentDate)
            ->get();

        foreach ($flights as $flight) {
            // Concatenar fecha y hora para comparación
            $departureDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $flight->departure_date . ' ' . $flight->departure_time);
            $arrivalDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $flight->departure_date . ' ' . $flight->arrival_time);

            if ($currentTime->greaterThanOrEqualTo($departureDateTime) && $currentTime->lessThan($arrivalDateTime)) {
                // Si la hora actual está entre la salida y la llegada -> "en trayecto"
                $flight->aircraft->update(['status' => 'en trayecto']);
            } elseif ($currentTime->greaterThanOrEqualTo($arrivalDateTime)) {
                // Si ya pasó la hora de llegada -> "finalizado"
                $flight->aircraft->update(['status' => 'finalizado']);
            } else {
                // Si aún no ha llegado la hora de salida -> "en espera"
                $flight->aircraft->update(['status' => 'en espera']);
            }
        }
    }
}
