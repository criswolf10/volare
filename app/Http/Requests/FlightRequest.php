<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlightRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Permitir acceso a todos los usuarios autorizados
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'regex:/^[A-Z]\d{3}[A-Z]$/', // letra mayúscula, 3 números y otra letra mayúscula
                'unique:flights,code', // Debe ser único en la tabla flights
            ],
            'origin' => 'required|string|max:255', // Ciudad de origen
            'destination' => 'required|string|max:255', // Ciudad de destino
            'duration' => 'required|date_format:H:i:s', // Formato de tiempo
            'departure_date' => 'required|date', // Fecha de vuelo
            'departure_time' => 'required|date_format:H:i:s', // Hora de salida
            'arrival_time' => 'required|date_format:H:i:s', // Hora de llegada
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'code.required' => 'El código del vuelo es obligatorio.',
            'code.regex' => 'El código debe ser una sola letra mayúscula.',
            'code.unique' => 'Este código ya está en uso, por favor elige otro.',
            'origin.required' => 'El origen del vuelo es obligatorio.',
            'destination.required' => 'El destino del vuelo es obligatorio.',
            'duration.required' => 'La duración del vuelo es obligatoria.',
            'departure_date.required' => 'La fecha de salida es obligatoria.',
            'departure_time.required' => 'La hora de salida es obligatoria.',
            'arrival_time.required' => 'La hora de llegada es obligatoria.',
        ];
    }
}
