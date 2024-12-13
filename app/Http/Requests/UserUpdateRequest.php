<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserUpdateRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'min:3', 'max:40'], // No es obligatorio, solo si se cambia
            'lastname' => ['nullable', 'string', 'min:3', 'max:70'], // No es obligatorio, solo si se cambia
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                // Único solo si el email cambia, ignorando el usuario actual
                "unique:users,email,{$this->route('id')}"
            ],
            'password' => [
                'nullable',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols(),
            ],
            'phone' => [
                'nullable', // Permite que el teléfono sea nulo
                'regex:/^\d{9}$/', // Solo números, exactamente 9 caracteres
                "unique:users,phone,{$this->route('id')}", // Único solo si el teléfono cambia
            ],

        ];
    }

    /**
     * Custom error messages for validation
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.min' => 'The name must be at least 3 characters.',
            'lastname.required' => 'The lastname field is required.',
            'email.unique' => 'This email is already in use.',
            'phone.unique' => 'This phone number is already registered.',
            'password.confirmed' => 'The passwords do not match.',
        ];
    }

    /**
     * Get the validated data with formatted phone
     */
    public function getValidatedData()
    {
        $data = $this->validated();

        // Si el teléfono ha sido proporcionado, asegurarse de que tenga 9 dígitos
        if (isset($data['phone'])) {
            // Elimina cualquier carácter no numérico
            $data['phone'] = preg_replace('/\D/', '', $data['phone']);

            // Verificar si el teléfono tiene exactamente 9 caracteres numéricos
            if (strlen($data['phone']) !== 9) {
                // Puedes lanzar un error o manejar este caso si lo deseas
                throw new \Exception('El número de teléfono debe tener exactamente 9 dígitos.');
            }
        }

        return $data;
    }
}
