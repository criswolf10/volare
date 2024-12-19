<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $credentials = $this->only('email', 'password');

        // Validación adicional para asegurar que los campos no estén vacíos
        if (empty($credentials['email'])) {
            throw ValidationException::withMessages([
                'email' => 'El correo electrónico es obligatorio. Por favor, ingrésalo.',
            ]);
        }

        if (empty($credentials['password'])) {
            throw ValidationException::withMessages([
                'password' => 'La contraseña es obligatoria. Por favor, ingrésala.',
            ]);
        }

        $user = \App\Models\User::where('email', $credentials['email'])->first();

        // Verificamos si el usuario existe
        if (!$user) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => 'El correo electrónico proporcionado no es correcto.',
            ]);
        }

        // Si el usuario existe, verificamos la contraseña
        if (!Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'password' => 'La contraseña ingresada es incorrecta. Intenta nuevamente.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }



    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => 'Demasiados intentos fallidos. Intenta nuevamente en :minutes minuto(s).',
        ]);
    }

    /**
     * Obtener la clave de limitación de tasa para la solicitud.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }
}
