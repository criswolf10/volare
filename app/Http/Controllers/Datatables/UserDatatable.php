<?php
namespace App\Http\Controllers\Datatables;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;


class UserDatatable
{
    /**
     * Obtener los datos de los usuarios para DataTables.
     */

public function getUserData(Request $request)
    {
        if ($request->ajax()) {
            // Crear la consulta base para los usuarios
            $query = User::select(['id', 'name', 'lastname', 'email', 'phone', 'created_at']);

            // Filtrar por roles
            if ($request->has('roles') && $request->roles) {
                $query->whereHas('roles', function ($q) use ($request) {
                    $q->whereIn('name', $request->roles);
                });
            }

            // Filtrar por rango de fechas
            if ($request->start_date || $request->end_date) {
                $startDate = $request->start_date
                    ? Carbon::createFromFormat('Y-m-d', $request->start_date)->startOfDay()
                    : null;

                $endDate = $request->end_date
                    ? Carbon::createFromFormat('Y-m-d', $request->end_date)->endOfDay()
                    : null;

                if ($startDate && $endDate) {
                    // Ambos valores están presentes
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                } elseif ($startDate) {
                    // Solo la fecha de inicio está presente
                    $query->where('created_at', '>=', $startDate);
                } elseif ($endDate) {
                    // Solo la fecha de fin está presente
                    $query->where('created_at', '<=', $endDate);
                }
            }

            // Obtener los usuarios filtrados
            $users = $query->get();

            // Devolver los datos a DataTables
            return DataTables::of($users)
                ->addColumn('full_name', function ($row) {
                    return $row->name . ' ' . $row->lastname;
                })
                ->addColumn('role', function ($row) {
                    return $row->getRoleNames()->join(', ');
                })

                // Formatear la fecha y hora de creación
                ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('d/m/Y H:i');
                })
                ->addColumn('action', function ($user) {
                    // Botón de edición
                    $editButton = '<a href="' . route('edit-users', ['id' => $user->id]) . '" class="btn btn-sm btn-primary">
                                        <img src="' . asset('icons/edit.png') . '" alt="edit">
                                    </a>';

                    // Botón de ver historial
                    // $showButton = '<a href="' . route('tickets.getTickets', ['id' => $user->id]) . '" class="btn btn-sm btn-info mx-2">
                    //                     <img src="' . asset('icons/history-tickets.png') . '" alt="view">
                    //                 </a>';

                    // Botón de eliminación con Alpine.js
                    $deleteButton = '<button class="btn btn-sm btn-danger"
                    x-data="{}"
                    x-on:click.prevent="$dispatch(\'user-deletion\', { userId: ' . $user->id . ' })">
                    <img src="' . asset('icons/delete.png') . '" alt="delete">
                </button>';



                    // Envolver los botones en un contenedor con clases de Tailwind para alinear en fila
                    return '<div id="action-btn" class="flex gap-3">' . $editButton  . $deleteButton .  '</div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
