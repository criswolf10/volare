<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisteredUserRequest extends FormRequest
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
            'name'=> ['required', 'string', 'min:3', 'max:40'],
            'lastname'=> ['required', 'string', 'min:3', 'max:70'],
            'email'=> [
                'required',
                'string',
                'email',
                'max:255',
                "unique:users,email" // Ignorar unicidad para el usuario actual en edición
            ],
            'password' => [
                $this->isMethod('patch') ? 'nullable' : 'required', // Contraseña solo requerida en creación
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols(),
            ],
            'phone' => [
            'required',
            'regex:/^\d{3}\d{3}\d{3}$/', // Validación para el formato 'xxx xxx xxx'
            "unique:users,phone" // Ignorar unicidad para el usuario actual en edición
        ],
        ];
    }


    public function messages(): array
{
    return [
        'name.required' => 'El campo nombre es obligatorio.',
        'name.min' => 'El nombre debe tener al menos 3 letras.',
        'lastname.required' => 'El campo apellido es obligatorio.',
        'email.unique' => 'Este correo ya está registrado.',
        'phone.unique' => 'Este teléfono ya está registrado.',
        'password.confirmed' => 'Las contraseñas no coinciden.',
    ];
}

public function getValidatedData()
{
    // Obtener los datos validados
    $data = $this->validated();

    // Formatear el teléfono al formato 'xxx xxx xxx'
    $data['phone'] = $this->formatPhoneNumber($data['phone']);

    return $data;
}

protected function formatPhoneNumber($phone)
{
    // Elimina cualquier carácter no numérico
    $phone = preg_replace('/\D/', '', $phone);

    // Formatea el número como 'xxx xxx xxx'
    return substr($phone, 0, 3) . ' ' . substr($phone, 3, 3) . ' ' . substr($phone, 6, 3);
}


}
