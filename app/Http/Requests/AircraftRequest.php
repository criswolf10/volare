<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AircraftRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Se debe configurar correctamente en base a tus necesidades de autorización
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',  // Nombre del avión
            'capacity' => 'required|integer|min:150',  // Capacidad mínima de 150 asientos
            'seats' => 'required|json',  // Distribución de asientos en formato JSON
            'status' => 'required|in:borrador,en espera,completo,en trayecto',  // Estatus del avión
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.in' => 'El nombre debe ser uno de los valores permitidos.',
            'capacity.required' => 'La capacidad es obligatoria.',
            'status.in' => 'El estado debe ser uno de los valores válidos: borrador, en espera, en trayecto, completo.',
        ];
    }
}
