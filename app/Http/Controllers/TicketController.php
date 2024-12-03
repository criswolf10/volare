<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Flight;
use Yajra\DataTables\Facades\DataTables;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("tickets");
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

    }





    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }

    public function getTicketsData(Request $request)
    {
        if ($request->ajax()) {
            // Asegúrate de cargar las relaciones correctamente
            $query = Ticket::with([
                'user:id,name,lastname',
                'flight:id,code,origin,destination,duration',
                'flight.aircraft:id,seat_codes' // Asegúrate de cargar el avión con el código de asiento
            ]);
            return DataTables::of($query)
                ->addColumn('full_name', function ($ticket) {
                    return $ticket->user->name . ' ' . $ticket->user->lastname;
                })
                ->addColumn('code', function ($ticket) {
                    // Verificar si la relación 'flight' existe antes de acceder a 'code'
                    return $ticket->flight ? $ticket->flight->code : 'N/A';
                })
                ->addColumn('origin', function ($ticket) {
                    // Verificar si la relación 'flight' existe antes de acceder a 'origin'
                    return $ticket->flight ? $ticket->flight->origin : 'N/A';
                })
                ->addColumn('destination', function ($ticket) {
                    // Verificar si la relación 'flight' existe antes de acceder a 'destination'
                    return $ticket->flight ? $ticket->flight->destination : 'N/A';
                })
                ->addColumn('duration', function ($ticket) {
                    // Verificar si la relación 'flight' existe antes de acceder a 'duration'
                    return $ticket->flight ? $ticket->flight->duration : 'N/A';
                })
                ->addColumn('seats_codes', function ($ticket) {
                    // Verificar si la relación 'flight' y 'aircraft' existen antes de acceder a 'seats_codes'
                    return ($ticket->flight && $ticket->flight->aircraft)
                        ? implode(", ", $ticket->flight->aircraft->seat_codes)
                        : 'N/A';
                })
                ->addColumn('purchase_date', function ($ticket) {
                    return $ticket->purchase_date ? $ticket->purchase_date->format('d/m/Y') : 'N/A';
                })
                ->addColumn('action', function ($ticket) {
                    return '<a href="#" class="btn btn-primary">Editar</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


}
