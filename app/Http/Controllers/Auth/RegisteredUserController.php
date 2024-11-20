<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'lastname' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'digits:9', 'unique:users,phone'],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        // Formatear el teléfono
        $formattedPhone = preg_replace('/(\d{3})(\d{2})(\d{2})(\d{2})/', '$1 $2 $3 $4', $request->phone);

        $user = User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $formattedPhone,
            'password' => Hash::make($request->password),
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



        // Redirigir al usuario al dashboard después de completar el registro
        return redirect()->route('home')->with('status', 'Registro exitoso');
    }
}
