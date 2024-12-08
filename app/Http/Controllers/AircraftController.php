<?php

namespace App\Http\Controllers;

use App\Models\Aircraft;
use App\Http\Requests\AircraftRequest;
use Illuminate\Http\Request;

class AircraftController extends Controller
{
    /**
     * Mostrar una lista de todos los aviones.
     */
    public function index()
    {
        $aircrafts = Aircraft::all();
        return view('aircrafts.index', compact('aircrafts'));
    }

    /**
     * Mostrar el formulario para crear un nuevo avión.
     */
    public function create()
    {
        return view('aircrafts.create');
    }

    /**
     * Almacenar un nuevo avión en la base de datos.
     */
    public function store(AircraftRequest $request)
    {
        $data = $request->validated();  // Validar los datos
        Aircraft::create($data);  // Crear el avión
        return redirect()->route('aircrafts.index')->with('success', 'Avión creado exitosamente.');
    }

    /**
     * Mostrar el formulario para editar un avión existente.
     */
    public function edit(Aircraft $aircraft)
    {
        return view('aircrafts.edit', compact('aircraft'));
    }

    /**
     * Actualizar un avión existente en la base de datos.
     */
    public function update(AircraftRequest $request, Aircraft $aircraft)
    {
        $data = $request->validated();
        $aircraft->update($data);  // Actualizar el avión
        return redirect()->route('aircrafts.index')->with('success', 'Avión actualizado exitosamente.');
    }

    /**
     * Eliminar un avión de la base de datos.
     */
    public function destroy(Aircraft $aircraft)
    {
        $aircraft->delete();
        return redirect()->route('aircrafts.index')->with('success', 'Avión eliminado exitosamente.');
    }
}
