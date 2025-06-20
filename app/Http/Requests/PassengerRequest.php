<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PassengerRequest extends FormRequest
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
    public function rules()
{
    return [
        'name' => 'required|string|min:3|max:255',
        'lastname' => 'required|string|min:3|max:255',
        'email' => 'required|email|unique:passengers,email',
        'phone' => 'required|numeric|digits:9|unique:passengers,phone',
        'dni' => 'required|regex:/^\d{8}[A-Za-z]$/|unique:passengers,dni',
    ];
}
}
