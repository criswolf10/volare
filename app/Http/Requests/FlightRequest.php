<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlightRequest extends FormRequest
{
    /**
     * Determinar si el usuario está autorizado para hacer esta solicitud.
     */
    public function authorize(): bool
    {
        return true; // Permitir acceso a todos los usuarios autorizados
    }

    /**
     * Obtener las reglas de validación para la solicitud.
     */
    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'regex:/^[A-Z]\d{3}[A-Z]$/', // Código de vuelo: letra, 3 dígitos, letra
                'unique:flights,code', // Debe ser único
            ],
            'origin' => 'required|string|max:255', // Ciudad de origen
            'destination' => 'required|string|max:255', // Ciudad de destino
            'departure_date' => 'required|date', // Fecha de salida
            'departure_time' => 'required|date_format:H:i', // Hora de salida (solo horas y minutos)
            'arrival_time' => 'required|date_format:H:i', // Hora de llegada (solo horas y minutos)
            'duration' => 'nullable|string', // Duración: calculada automáticamente
            'aircraft_id' => 'required|exists:aircrafts,id', // El avión seleccionado debe existir en la tabla aircrafts

        ];
    }

    /**
     * Mensajes personalizados para los errores de validación.
     */
    public function messages(): array
    {
        return [
            'code.required' => 'El código del vuelo es obligatorio.',
            'code.regex' => 'El código debe ser una letra mayúscula seguida de 3 dígitos y otra letra mayúscula.',
            'code.unique' => 'Este código de vuelo ya está en uso, por favor elige otro.',
            'origin.required' => 'El origen del vuelo es obligatorio.',
            'destination.required' => 'El destino del vuelo es obligatorio.',
            'departure_time.after' => 'La hora de salida debe ser anterior a la hora de llegada.',
            'departure_date.required' => 'La fecha de salida es obligatoria.',
            'departure_time.required' => 'La hora de salida es obligatoria.',
            'arrival_time.required' => 'La hora de llegada es obligatoria.',
            'duration.required' => 'La duración del vuelo es obligatoria.',
            'aircraft.required' => 'El avión seleccionado es obligatorio.',
            'aircraft.exists' => 'El avión seleccionado no es válido.',

        ];
    }
}
