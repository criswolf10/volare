<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class UserController extends Controller
{

    public function index()
    {

        $user = Auth::user();
        if ($user->hasRole('admin')) {
            return view('users');
        } else {
            return redirect()->route('profile.edit');
        }
    }



    public function userEdit($id)
    {
        $user = User::findOrFail($id); // Busca al usuario por ID o lanza un error 404
        return view('admin.edit-users', compact('user'));
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


        // Redirigir con el modal mostrando el éxito
        return redirect()->route('create-users')->with('success', 'Usuario creado con éxito.');
    }

    // Actualizar un usuario
    public function userUpdate(UserRequest $userRequest): RedirectResponse
    {
        // Busca el usuario con el ID proporcionado
        $user = User::findOrFail($userRequest->route('id'));

        // Actualiza solo los campos válidos
        $user->fill($userRequest->validated());

        // Limpia el campo 'email_verified_at' si cambia el email
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Actualiza la contraseña solo si se envía
        if ($userRequest->filled('password')) {
            $user->password = bcrypt($userRequest->password);
        }


        // Asignar el rol al usuario
        $role = $userRequest->input('role');
        if ($role) {
            $user->assignRole($role);
        }

        // Guarda los cambios
        $user->save();

        return redirect()->route('edit-users', $user->id)->with('success', 'User updated successfully');
    }




    // Eliminar un usuario
    public function destroy(Request $request, $id)
    {


        // Validar solo la contraseña para la eliminación
        $request->validate([
            'password' => 'required|string',
        ]);

        // Obtener el usuario administrador autenticado
        $adminUser = Auth::user();

        // Verificar que la contraseña es correcta
        if (!Hash::check($request->password, $adminUser->password)) {
            return redirect()
                ->back()
                ->withErrors(['password' => 'La contraseña ingresada no es correcta.'])
                ->withInput();
        }

        // Buscar el usuario que se desea eliminar
        $user = User::findOrFail($id);

        // Verificar que el usuario no se esté eliminando a sí mismo
        if ($adminUser->id === $user->id) {
            return redirect()
                ->back()
                ->withErrors(['password' => 'No puedes eliminar tu propia cuenta.']);
        }

        // Eliminar al usuario
        $user->delete();




        // Redirigir con el modal de éxito
        return redirect()->route('users')->with('success', 'Usuario eliminado con éxito.');
    }






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
                    $showButton = '<a href="' . route('sales.getTickets', ['id' => $user->id]) . '" class="btn btn-sm btn-info mx-2">
                                        <img src="' . asset('icons/history-tickets.png') . '" alt="view">
                                    </a>';

                    // Botón de eliminación con Alpine.js
                    $deleteButton = '<button class="btn btn-sm btn-danger"
                    x-data="{}"
                    x-on:click.prevent="$dispatch(\'user-deletion\', { userId: ' . $user->id . ' })">
                    <img src="' . asset('icons/delete.png') . '" alt="delete">
                </button>';



                    // Envolver los botones en un contenedor con clases de Tailwind para alinear en fila
                    return '<div id="action-btn" class="flex gap-3">' . $editButton . $showButton . $deleteButton .  '</div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
