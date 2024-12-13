<?php

namespace App\Http\Controllers\Datatables;

use App\Models\Ticket;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class UserTicketsDatatable
{
    public function getUserTickets(Request $request)
    {
        // Obtén el usuario autenticado
        $user = auth()->user();

        if ($request->ajax()) {
            // Verifica el rol del usuario y obtiene los tickets correspondientes
            if ($user->hasRole('client')) {
                // Clientes: Solo muestra sus propios tickets
                $query = Ticket::where('user_id', $user->id)
                    ->with([
                        'user:id,name,lastname',
                        'flight:id,code,origin,destination',
                    ])
                    ->latest();
            } elseif ($user->hasRole('admin')) {
                // Administradores: Muestra todos los tickets
                $query = Ticket::with([
                    'user:id,name,lastname',
                    'flight:id,code,origin,destination',
                ])
                    ->latest();
            } else {
                // Caso por defecto: No devuelve tickets
                $query = collect(); // Colección vacía
            }

            // Utiliza DataTables para construir la respuesta
            return DataTables::of($query)

                ->addColumn('code', function ($ticket) {
                    return $ticket->flight->code ?? 'N/A';
                })
                ->addColumn('origin', function ($ticket) {
                    return $ticket->flight->origin ?? 'N/A';
                })
                ->addColumn('destination', function ($ticket) {
                    return $ticket->flight->destination ?? 'N/A';
                })
                ->addColumn('purchase_date', function ($ticket) {
                    return $ticket->purchase_date ? $ticket->purchase_date->format('d/m/Y H:i') : 'N/A';
                })
                ->addColumn('action', function ($ticket) {
                    $url = route('tickets.previewInvoice', ['id' => $ticket->id]);
                    return '<a href="' . $url . '" class="btn btn-sm btn-primary " target="_blank">
                                <img src="' . asset('icons/invoice.png') . '" alt="invoice">
                            </a>';
                })
                ->rawColumns(['action']) // Permite HTML en esta columna
                ->make(true);
        }
    }
}
