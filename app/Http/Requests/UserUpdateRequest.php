<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

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
        $userId = $this->route('id'); // ID del usuario actual

        return [
            'name' => ['sometimes', 'nullable', 'string', 'min:3', 'max:40'],
            'lastname' => ['sometimes', 'nullable', 'string', 'min:3', 'max:70'],
            'email' => [
                'sometimes', // Solo validar si está presente
                'required',
                'email',
                'max:255',
                // Validar que sea único solo si cambia
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'password' => [
                'sometimes',
                'nullable',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols(),
            ],
            'phone' => [
                'sometimes', // Solo validar si está presente
                'nullable',
                'regex:/^\d{9}$/', // Validar formato si hay valor
                Rule::unique('users', 'phone')->ignore($userId),
            ],
            'role' => ['sometimes', 'string', 'exists:roles,name'], // Validar roles si se incluyen
        ];
    }




    /**
     * Custom error messages for validation
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'lastname.required' => 'El campo apellido es obligatorio.',
            'email.unique' => 'Este correo electrónico ya está en uso.',
            'phone.unique' => 'Este número de teléfono ya está registrado.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
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
