<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Flight;
use App\Http\Requests\TicketRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TicketController extends Controller
{
    /**
     * Mostrar una lista de todos los tickets.
     */
    public function index()
    {
        $tickets = Ticket::all();
        return view('tickets', compact('tickets'));
    }

    /**
     * Mostrar el formulario para crear un nuevo ticket.
     */
    public function create()
    {
        $flights = Flight::all();  // Obtener todos los vuelos disponibles
        return view('purchase-form', compact('flights'));
    }

    /**
     * Almacenar un nuevo ticket en la base de datos.
     */
    public function store(TicketRequest $request)
    {
        $data = $request->validated();  // Validar los datos

        // Crear el ticket con los asientos seleccionados
        $ticket = Ticket::create($data);

        // Relacionar los asientos con el ticket
        $ticket->seats = $request->seats;
        $ticket->save();

        return redirect()->route('tickets')->with('success', 'Ticket comprado exitosamente.');
    }

    /**
     * Mostrar el formulario para editar un ticket existente.
     */
    public function edit(Ticket $ticket)
    {
        $flights = Flight::all();  // Obtener todos los vuelos disponibles
        return view('tickets.edit', compact('ticket', 'flights'));
    }

    /**
     * Actualizar un ticket existente en la base de datos.
     */
    public function update(TicketRequest $request, Ticket $ticket)
    {
        $data = $request->validated();
        $ticket->update($data);  // Actualizar el ticket
        $ticket->seats = $request->seats; // Actualizar los asientos
        $ticket->save();

        return redirect()->route('tickets')->with('success', 'Ticket actualizado exitosamente.');
    }

    /**
     * Eliminar un ticket de la base de datos.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets')->with('success', 'Ticket eliminado exitosamente.');
    }
}
