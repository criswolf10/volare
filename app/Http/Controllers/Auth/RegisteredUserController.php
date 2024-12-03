<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserRequest $UserRequest)
    {

        $user = User::create([
            'name' => $UserRequest->name,
            'lastname' => $UserRequest->lastname,
            'email' => $UserRequest->email,
            'phone' => $UserRequest->phone,
            'password' => Hash::make($UserRequest->password),
        ]);

        // Asignar rol basado en si es el primer usuario
        if (User::count() === 1) {
            $user->assignRole('admin');
        } else {
            $user->assignRole('client');
        }

        // Asignar la URL de la imagen predeterminada
        $defaultImageUrl = 'img/avatar.png';
        $user->addMedia(public_path($defaultImageUrl))
            ->preservingOriginal()
            ->usingFileName('avatar.png')
            ->toMediaCollection('profile_photos');

        // Disparar el evento de registro
        event(new Registered($user));



        // Redirigir con el modal mostrando el éxito
        return redirect()->route('home')->with('success', 'Usuario creado con éxito.');
    }
}
