<?php

namespace App\Http\Controllers\Datatables;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;


class TicketDatatable
{
    public function getTicketsData(Request $request)
    {
        if ($request->ajax()) {
            // Asegúrate de cargar las relaciones correctamente
            $query = Ticket::with([
                'user:id,name,lastname',
                'flight:id,code,origin,destination,duration',
                'flight.aircraft:id,seats' // Asegúrate de cargar el avión con el código de asiento
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
                    return $ticket->price
                        ? number_format($ticket->price, 0, ',', '.') . '€' // Sin decimales si es un número entero
                        : number_format($ticket->price, 2, ',', '.') . '€'; // Con decimales si es un número flotante
                })


                ->addColumn('duration', function ($ticket) {
                    // Verificar si la relación 'flight' existe antes de acceder a 'duration'
                    return $ticket->flight ? $ticket->flight->duration : 'N/A';
                })
                ->addColumn('seats', function ($ticket) {
                    // Verificar si la relación 'flight' y 'aircraft' existen antes de acceder a 'seats_codes'
                    return ($ticket->flight && $ticket->flight->aircraft)
                        ? implode(", ", $ticket->flight->aircraft->seats)
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
