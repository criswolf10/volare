<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    public function index()
    {
        return view('users');
    }


    public function userEdit()
    {
        return view('admin.edit-users');
    }

    // Crear un nuevo usuario

    public function userCreate(UserRequest $userRequest)
    {
        $user = new User();
        $user->name = $userRequest->name;
        $user->lastname = $userRequest->lastname;
        $user->email = $userRequest->email;
        $user->password = bcrypt($userRequest->password);
        $user->phone = $userRequest->phone;
        $user->save();


        // Asignar el rol al usuario
        $role = $userRequest->input('role');
        if ($role) {
            $user->assignRole($role);
        }


        return response()->json(['success' => 'User created successfully']);
    }

    // Actualizar un usuario

    public function userUpdate(UserRequest $userRequest)
    {
        $user = User::find($userRequest->id);
        $user->name = $userRequest->name;
        $user->lastname = $userRequest->lastname;
        $user->email = $userRequest->email;
        $user->phone = $userRequest->phone;
        $user->save();
        $role = $userRequest->input('role');
        if ($role) {
            $user->assignRole($role);
        }
        return response()->json(['success' => 'User updated successfully']);
    }


    // Eliminar un usuario

    public function userDelete(UserRequest $userRequest)
    {
        $user = User::find($userRequest->id);
        $user->delete();
        return response()->json(['success' => 'User deleted successfully']);
    }




    public function getUserData(Request $request)
    {
        if ($request->ajax()) {
            // Crear la consulta base para los usuarios
            $query = User::select(['id', 'name', 'lastname', 'email', 'phone', 'created_at']);

            // Verificar si se han pasado roles para el filtrado
            if ($request->has('roles') && !empty($request->roles)) {
                // Filtrar los usuarios que tienen uno de los roles seleccionados
                $query->whereHas('roles', function ($q) use ($request) {
                    $q->whereIn('name', $request->roles);  // Filtrar por los roles seleccionados
                });
            }

            // Obtener los usuarios filtrados
            $users = $query->get();

            // Devolver los datos a DataTables
            return DataTables::of($users)
                ->addColumn('full_name', function ($row) {
                    return $row->name . ' ' . $row->lastname;
                })
                ->addColumn('role', function ($row) {
                    // Traducimos los roles desde el archivo JSON
                    return $row->getRoleNames()->map(function ($role) {
                        return __(strtolower($role)); // Traduce el rol usando las claves definidas en es.json
                    })->join(', ');
                })
                ->addColumn('action', function ($user) {
                    // Construir los enlaces de acción, por ejemplo, editar y ver
                    $editButton = '<a href="' . route('edit-users', ['id' => $user->id]) . '" class="btn btn-sm btn-primary">
                                <img src="' . asset('icons/edit.png') . '" alt="edit">
                            </a>';

                    $showButton = '<a href="' . route('sales.getTickets', ['id' => $user->id]) . '" class="btn btn-sm btn-info mx-2">
                                <img src="' . asset('icons/history-tickets.png') . '" alt="view">
                            </a>';

                    // Opción de eliminar con un formulario, protegiendo la acción DELETE
                    $deleteButton = '<form action="' . route('user-delete', ['id' => $user->id]) . '" method="POST" class="inline">
                                    ' . csrf_field() . '
                                    ' . method_field('DELETE') . '
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este usuario?\')">
                                        <img src="' . asset('icons/delete.png') . '" alt="delete">
                                    </button>
                                </form>';

                    // Envolver los botones en un contenedor con clases de Tailwind para alinear en fila
                    return '<div id="action-btn" class="flex gap-3">' . $editButton . $showButton . $deleteButton . '</div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
