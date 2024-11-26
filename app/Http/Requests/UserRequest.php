<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
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
        $userId = $this->route('id'); // Captura el ID del usuario de la ruta (solo aplica en edición)

        return [
            'name'=> ['required', 'string', 'min:3', 'max:40'],
            'lastname'=> ['required', 'string', 'min:3', 'max:70'],
            'email'=> [
                'required',
                'string',
                'email',
                'max:255',
                "unique:users,email,{$userId}" // Ignorar unicidad para el usuario actual en edición
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
                'digits:9',
                "unique:users,phone,{$userId}" // Ignorar unicidad para el usuario actual en edición
            ],
        ];
    }


    public function messages(): array
{
    return [
        'name.required' => 'The name field is required.',
        'lastname.required' => 'The lastname field is required.',
        'email.unique' => 'This email is already in use.',
        'phone.unique' => 'This phone number is already registered.',
        'password.confirmed' => 'The passwords do not match.',
    ];
}

}
