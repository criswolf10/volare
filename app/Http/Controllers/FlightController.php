<?php

namespace App\Http\Controllers;

use App\Http\Requests\FlightRequest;
use App\Http\Requests\UserRequest;
use App\Models\Flight;
use App\Models\Aircraft;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        return view('admin.edit-flights', compact('flight', 'aircrafts'));
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
    public function destroy(UserRequest $request , $id)
    {
        //Validar contraseña del usuario para la eliminacion
        $request->validate([
            'password' => 'required|string',
        ]);

        //Obtener el usuario administrador autenticado
        $adminUser = Auth::user();

        //Verificar si la contraseña del usuario autenticado es correcta
        // Verificar que la contraseña es correcta
        if (!Hash::check($request->password, $adminUser->password)) {
            return redirect()
                ->back()
                ->withErrors(['password' => 'La contraseña ingresada no es correcta.'])
                ->withInput();
        }

        // Buscar el vuelo por ID
        $flight = Flight::findOrFail($id);

        // Eliminar el vuelo
        $flight->delete();

        // Redirigir con mensaje de éxito
        return redirect()
            ->route('flights')
            ->with('success', 'Vuelo eliminado exitosamente.');
    }
}
