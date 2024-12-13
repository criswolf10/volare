<?php

namespace App\Http\Controllers;

use App\Http\Requests\FlightRequest;
use App\Http\Requests\UserDeleteRequest;
use App\Http\Requests\FlightUpdateRequest;
use App\Mail\FlightCancelled;
use App\Models\Flight;
use App\Models\Aircraft;
use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Puedes incluir datos adicionales si son necesarios, como una lista de aviones disponibles
        $aircrafts = Aircraft::all(); // Obtener los aviones disponibles
        return view('admin.create-flights', compact('aircrafts'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(FlightRequest $request)
    {
        // Crear un nuevo vuelo con los datos validados
        $flight = Flight::create($request->validated());

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

        // Actualizar los datos del vuelo
        $flight->update([
            'aircraft_id' => $request->input('aircraft_id'),
            'departure_date' => $request->input('departure_date'),
            'departure_time' => Carbon::parse($request->input('departure_time'))->format('H:i'),
            'arrival_time' => Carbon::parse($request->input('arrival_time'))->format('H:i'),
        ]);

        // Calcular la duración del vuelo
        $departureTime = Carbon::parse($request->input('departure_time'));
        $arrivalTime = Carbon::parse($request->input('arrival_time'));
        $durationInMinutes = $departureTime->diffInMinutes($arrivalTime);

        // Convertir la duración a formato legible
        $formattedDuration = sprintf(
            '%d hora%s%s%d minuto%s',
            floor($durationInMinutes / 60),
            floor($durationInMinutes / 60) > 1 ? 's' : '',
            floor($durationInMinutes / 60) && $durationInMinutes % 60 ? ' y ' : '',
            $durationInMinutes % 60,
            $durationInMinutes % 60 > 1 ? 's' : ''
        );

        // Actualizar la duración en el modelo
        $flight->duration = trim($formattedDuration, ' y ');

        // Actualizar los precios de los tickets
        foreach (['1ª clase' => 'price_first_class', '2ª clase' => 'price_second_class', 'turista' => 'price_tourist'] as $class => $inputField) {
            if ($request->has($inputField)) {
                Ticket::where('flight_id', $flight->id)
                    ->where('class', $class)
                    ->update(['price' => $request->input($inputField)]);
            }
        }

        // Actualizar los datos del vuelo
        $flight->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('flights')->with('success', 'Vuelo actualizado correctamente.');
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
                Mail::to($user->email)->send(new FlightCancelled($flight));
            }
        }

        // Eliminar los tickets asociados al vuelo
        $flight->tickets()->delete();

        // Eliminar el vuelo
        $flight->delete();

        // Redirigir con mensaje de éxito
        return redirect()
            ->route('flights')
            ->with('success_cancelled');
    }




    public function dashboard()
    {
        $user = auth()->user();

        // Datos para clientes: Últimos vuelos recientes
        $latestFlights = Flight::latest()->take(5)->get();

        // Datos para administradores: Vuelos con más plazas vacantes
        $flightsWithVacancies = Flight::withCount(['tickets as seats_taken' => function ($query) {
            $query->where('status', 'confirmed');
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
}
