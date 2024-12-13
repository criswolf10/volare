<?php

namespace App\Http\Controllers\Datatables;


use App\Models\Ticket;
use Yajra\DataTables\DataTables;
use App\Models\User;
use Illuminate\Http\Request;


class LastTicketsUserDatatable
{
    public function getLastTicketsUser(Request $request)
    {
        // Obtén el usuario autenticado
        $user = auth()->user();
        if ($request->ajax()) {
            if ($user->hasRole('client')) {
                // Consulta para clientes: Solo muestra sus propios tickets
                $query = Ticket::where('user_id', $user->id)
                    ->with([
                        'user:id,name,lastname',
                        'flight:id,code,origin,destination',
                    ])
                    ->latest()
                    ->take(4)
                    ->get();
            } elseif ($user->hasRole('admin')) {
                // Consulta para administradores: Muestra todos los tickets
                $query = Ticket::with([
                    'user:id,name,lastname',
                    'flight:id,code,origin,destination',
                ])
                    ->latest()
                    ->take(4)
                    ->get();
            } else {
                // Caso por defecto si el rol no es ni cliente ni administrador
                $query = collect(); // Retorna una colección vacía
            }

            // Utiliza DataTables para construir la respuesta
            return DataTables::of($query)
                ->addColumn('full_name', function ($ticket) {
                    return $ticket->user->name . ' ' . $ticket->user->lastname;
                })
                ->addColumn('code', function ($ticket) {
                    return $ticket->flight->code ?? 'N/A';
                })
                ->addColumn('origin', function ($ticket) {
                    return $ticket->flight->origin ?? 'N/A';
                })
                ->addColumn('destination', function ($ticket) {
                    return $ticket->flight->destination ?? 'N/A';
                })

                ->addColumn('action', function ($ticket) {
                    $url = route('tickets.previewInvoice', ['id' => $ticket->id]);
                    return '<a href="' . $url . '" class="btn btn-sm btn-primary" target="_blank">
                                <img src="' . asset('icons/invoice.png') . '" alt="invoice">
                            </a>';
                })

                ->rawColumns(['action']) // Permite HTML en esta columna
                ->make(true);
        }
    }


}
