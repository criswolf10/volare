<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {

        return false; 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id', // El usuario debe existir en la tabla users
            'flight_id' => 'required|exists:flights,id', // El vuelo debe existir en la tabla flights
            'price' => 'required|numeric|min:0', // El precio debe ser un número positivo
            'purchase_date' => 'required|date', // La fecha de compra debe ser una fecha válida
            'seats' => 'required|array|min:1', // Los asientos deben ser un array con al menos un asiento
            'seats.*' => 'string', // Cada asiento debe ser una cadena
        ];
    }
}
