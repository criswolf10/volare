<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class FlightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('flights');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'regex:/^[A-Z]{1}[0-9]{3}[A-Z]{1}$/'], // 1 letra, 3 dígitos, 1 letra
            'aircraft' => ['required', 'regex:/^[0-9]{3} [A-Z]{3}$/'], // 3 dígitos, espacio, 3 letras
            'origin' => ['required', 'string', 'max:255'], // Nombre de la ciudad
            'destination' => ['required', 'string', 'max:255'], // Nombre de la ciudad
            'duration' => ['required', 'regex:/^([0-9]+h)? ?([0-5]?[0-9]m)?$/', function ($attribute, $value, $fail) {
                // Verificar duración mínima
                preg_match('/^([0-9]+h)? ?([0-5]?[0-9]m)?$/', $value, $matches);
                $hours = isset($matches[1]) ? (int) filter_var($matches[1], FILTER_SANITIZE_NUMBER_INT) : 0;
                $minutes = isset($matches[2]) ? (int) filter_var($matches[2], FILTER_SANITIZE_NUMBER_INT) : 0;
                $totalMinutes = $hours * 60 + $minutes;

                if ($totalMinutes < 35) {
                    $fail('La duración mínima debe ser de al menos 35 minutos.');
                }
            }],
            'departure_date' => ['required', 'date', 'after_or_equal:today', 'before_or_equal:+1 year'], // De hoy a 1 año
            'departure_time' => ['required', 'date_format:H:i'], // Hora válida
            'arrival_time' => ['required', 'date_format:H:i', 'after:departure_time'], // Llegada posterior a la salida
            'seats_class' => ['required', Rule::in(['1ª clase', '2ª clase', 'turista'])], // Clases válidas
            'status' => ['required', Rule::in(['borrador', 'en espera', 'en trayecto', 'completo'])],
        ]);

        $flight = Flight::create($validated);

        return response()->json($flight, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Flight $flight)
    {
        $validated = $request->validate([
            'code' => ['required', 'regex:/^[A-Z]{1}[0-9]{3}[A-Z]{1}$/'], // Misma validación
            'aircraft' => [
                'required',
                'regex:/^[0-9]{3} [A-Z]{3}$/',
                Rule::unique('flights')->where(function ($query) use ($request) {
                    return $query->where('destination', $request->destination);
                })
            ],
            'origin' => ['required', 'string', 'max:255'],
            'destination' => ['required', 'string', 'max:255'],
            'duration' => ['sometimes', 'regex:/^([0-9]+h)? ?([0-5]?[0-9]m)?$/', function ($attribute, $value, $fail) {
                preg_match('/^([0-9]+h)? ?([0-5]?[0-9]m)?$/', $value, $matches);
                $hours = isset($matches[1]) ? (int) filter_var($matches[1], FILTER_SANITIZE_NUMBER_INT) : 0;
                $minutes = isset($matches[2]) ? (int) filter_var($matches[2], FILTER_SANITIZE_NUMBER_INT) : 0;
                $totalMinutes = $hours * 60 + $minutes;

                if ($totalMinutes < 35) {
                    $fail('La duración mínima debe ser de al menos 35 minutos.');
                }
            }],
            'departure_date' => ['required', 'date', 'after_or_equal:today', 'before_or_equal:+1 year'],
            'departure_time' => ['required', 'date_format:H:i'],
            'arrival_time' => ['required', 'date_format:H:i', 'after:departure_time'],
            'seats_class' => ['required', Rule::in(['1ª clase', '2ª clase', 'turista'])],
            'status' => ['required', Rule::in(['cancelado', 'en espera', 'en trayecto', 'completo'])],
        ]);

        $flight->update($validated);

        return response()->json($flight);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Flight $flight)
    {
        $flight->delete();
        return response()->json(['message' => 'Flight deleted successfully']);
    }

    //     public function getFlights(Request $request)
    //     {
    //     if ($request->ajax()) {
    //         $flight = Flight::all();

    //         return DataTables::of($flight)
    //     }
    // }

}
