<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Flight;
use App\Models\Aircraft;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            // Para el admin: últimos 4 billetes vendidos
            $lastTickets = Ticket::latest()->take(4)->get();

            // Últimos 4 vuelos con menos plazas libres
            $flightsWithSeats = Flight::with('aircraft') // Asegúrate de que la relación 'aircraft' esté definida
                ->get()
                ->map(function ($flight) {
                    // Calculamos la cantidad de plazas libres
                    $seatsSold = $flight->tickets->count(); // Contamos cuántos tickets se han vendido
                    $availableSeats = $flight->aircraft->capacity - $seatsSold; // Restamos los billetes vendidos de la capacidad del avión
                    $flight->available_seats = $availableSeats; // Agregamos un atributo con las plazas libres
                    return $flight;
                })
                ->sortBy('available_seats') // Ordenamos por las plazas libres
                ->take(4); // Tomamos los primeros 4 vuelos con menos plazas libres

            return view('dashboard', compact('lastTickets', 'flightsWithSeats'));
        } else {
            // Para el cliente: últimos 4 billetes comprados
            $lastTickets = Ticket::where('user_id', $user->id)->latest()->take(4)->get();

            // Últimos 4 vuelos más recientes
            $latestFlights = Flight::latest()->take(4)->get();

            return view('dashboard', compact('lastTickets', 'latestFlights'));
        }
    }
}
