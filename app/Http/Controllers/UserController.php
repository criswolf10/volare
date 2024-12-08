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
}
