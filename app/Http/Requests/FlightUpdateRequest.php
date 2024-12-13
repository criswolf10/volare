<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Flight;

class FlightUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Cambiar si es necesario para control de permisos
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {// Recuperar el ID del vuelo desde la ruta
    $flightId = $this->route('id');

    // Buscar el vuelo en la base de datos
    $flight = Flight::find($flightId);

    if (!$flight) {
        abort(404, 'Vuelo no encontrado'); // Manejo del error si el vuelo no existe
    }

    return [
        'aircraft_id' => 'nullable|exists:aircrafts,id|different:' . $flight->aircraft_id,
        'departure_date' => 'nullable|date|after_or_equal:' . now()->addDays(3)->toDateString(),
        'departure_time' => 'nullable|date_format:H:i',
        'arrival_time' => 'nullable|date_format:H:i|after:departure_time',
    ];
}



    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'aircraft_id.required' => 'Debe seleccionar un avión disponible.',
            'aircraft_id.exists' => 'El avión seleccionado ya está ocupado.',
            'departure_date.required' => 'La fecha de salida es obligatoria.',
            'departure_date.after_or_equal' => 'La fecha de salida debe ser al menos 3 días después de la fecha actual.',
            'departure_time.required' => 'La hora de salida es obligatoria.',
            'departure_time.date_format' => 'El formato de la hora de salida debe ser HH:mm.',
            'arrival_time.required' => 'La hora de llegada es obligatoria.',
            'arrival_time.date_format' => 'El formato de la hora de llegada debe ser HH:mm.',
            'arrival_time.after' => 'La hora de llegada debe ser posterior a la hora de salida.',
        ];
    }
}
