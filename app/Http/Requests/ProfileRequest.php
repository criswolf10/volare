<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Password;

class ProfileRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:40'],
            'lastname' => ['required', 'string', 'min:3', 'max:70'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->user()->id],
            'phone' => ['required', 'digits:9', 'unique:users,phone,' . $this->user()->id],
            // Validación de contraseña solo si se envía
            'password' => [
                'nullable', // Contraseña no requerida
                'confirmed', // Asegura que la contraseña se confirme
                'min:8', // Contraseña debe tener al menos 8 caracteres
                'regex:/[a-z]/', // Debe contener al menos una letra minúscula
                'regex:/[A-Z]/', // Debe contener al menos una letra mayúscula
                'regex:/[0-9]/', // Debe contener al menos un número
                'regex:/[@$!%*?&]/', // Debe contener al menos un símbolo especial
            ],

        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Por favor, ingresa un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'phone.required' => 'El teléfono es obligatorio.',
            'phone.digits' => 'El teléfono debe tener 9 dígitos.',
            'phone.unique' => 'Este número de teléfono ya está registrado.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.mixedCase' => 'La contraseña debe tener mayúsculas y minúsculas.',
            'password.letters' => 'La contraseña debe contener letras.',
            'password.numbers' => 'La contraseña debe contener números.',
            'password.symbols' => 'La contraseña debe contener al menos un símbolo.',
        ];
    }
}
