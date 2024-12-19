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
    $authUser = auth()->user();

    if ($request->ajax()) {
        $query = Ticket::query()
            ->with([
                'user:id,name,lastname',
                'flight:id,code,origin,destination',
                'seat:id,seat_code,class,price'
            ]);

        // Lógica para clientes: solo pueden ver sus propios tickets
        if ($authUser->hasRole('client')) {
            $query->where('user_id', $authUser->id);
        }

        // Lógica para administradores: pueden ver tickets de un usuario específico
        elseif ($authUser->hasRole('admin') && $request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        // Si es administrador y no pasa user_id, puede ver todos los tickets
        $query->latest();

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
            ->addColumn('seat_code', function ($ticket) {
                return $ticket->seat ? $ticket->seat->seat_code : 'N/A';
            })
            ->addColumn('purchase_date', function ($ticket) {
                return $ticket->purchase_date ? $ticket->purchase_date->format('d/m/Y H:i:s') : 'N/A';
            })

            ->addColumn('action', function ($ticket) {
                // Botón de Invoice (siempre disponible)
                $successButton = route('tickets.success', ['ticketId' => $ticket->id]);
                $successButton = '<a href="' . $successButton . '" class="btn btn-sm btn-primary" target="_blank">
                                    <img src="' . asset('icons/invoice.png') . '" alt="invoice">
                                </a>';

                // Botón de Cancel (solo disponible para clientes)
                $cancelButton = '';
                if (auth()->user()->hasRole('client')) {
                    $cancelButton = route('cancel-ticket', ['ticketId' => $ticket->id]);
                    $cancelButton = '<a href="' . $cancelButton . '" class="btn btn-sm btn-danger">
                                        <img src="' . asset('icons/cancel.png') . '" alt="cancel">
                                    </a>';
                }

                return '<div id="action-btn" class="flex gap-3">' . $successButton . $cancelButton . '</div>';
            })

            ->rawColumns(['action']) // Permite HTML en esta columna
            ->make(true);
    }
}

}
