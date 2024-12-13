<?php

namespace App\Http\Controllers;

use App\Http\Requests\FlightRequest;
use App\Http\Requests\UserDeleteRequest;
use App\Http\Requests\UserRequest;
use App\Mail\FlightCancelled;
use App\Models\Flight;
use App\Models\Aircraft;
use Illuminate\Http\Request;
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
    public function edit($id)
    {
        $aircrafts = Aircraft::all(); // Obtener aviones disponibles para editar la relación
        $flight = Flight::findOrFail($id); // Buscar el vuelo por ID

        // Obtener todos los precios de los tickets
        $ticketPrice = $flight->tickets()->pluck('price');

        return view('admin.edit-flights', compact('flight', 'aircrafts', 'ticketPrice'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(FlightRequest $request)
    {
        // Buscar el vuelo por ID
        $flight = Flight::findOrFail($request->route('id'));

        // Actualizar el vuelo con los datos validados
        $flight->update($request->all());

        // Guardar los cambios
        $flight->save();



        // Redireccionar a la vista de vuelos con un mensaje
        return redirect()->route('flights')->with('success', '¡Vuelo actualizado correctamente!');
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
            ->with('success');
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
