<?php

namespace App\Http\Controllers\Datatables;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;


class TicketsDatatable
{
    public function getTicketsData(Request $request)
    {
        if ($request->ajax()) {

            $query = Ticket::with([
                'user:id,name,lastname', // Relación con User
                'flight:id,code,origin,destination,duration', // Relación con Flight
                'seat:id,seat_code,class,price' // Relación con AircraftSeat
            ]);

            //devolver todos los datos formateados para DataTables

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
                ->addColumn('price', function ($ticket) {
                    return $ticket->seat ? '$' . number_format($ticket->seat->price, 2) : 'N/A';
                })
                ->addColumn('seat_code', function ($ticket) {
                    return $ticket->seat ? $ticket->seat->seat_code : 'N/A';
                })

                ->addColumn('duration', function ($ticket) {
                    // Verificar si la relación 'flight' existe antes de acceder a 'duration'
                    return $ticket->flight ? $ticket->flight->duration : 'N/A';
                })
                ->addColumn('purchase_date', function ($ticket) {
                    return $ticket->purchase_date ? $ticket->purchase_date->format('d/m/Y H:i:s') : 'N/A';
                })

                ->addColumn('action', function ($ticket) {
                    return '<a href="' . route('user-tickets', ['userId' => $ticket->user->id]) . '" class="btn btn-sm btn-info mx-2">
                                <img src="' . asset('icons/history-tickets.png') . '" alt="view">
                            </a>';
                })





                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
