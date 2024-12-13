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

        if ($user && $user->hasRole('admin')) {
            // Lógica para el administrador
            $lastTickets = Ticket::latest()->take(4)->get();

            $flightsWithVacancies = Flight::with('aircraft')
                ->get()
                ->map(function ($flight) {
                    $occupiedSeats = $flight->tickets()->count();
                    $totalSeats = $flight->aircraft->capacity;
                    $freeSeats = $totalSeats - $occupiedSeats;

                    $flight->free_percentage = $totalSeats > 0 ? round(($freeSeats / $totalSeats) * 100) : 0;

                    return $flight;
                })
                ->sortByDesc('free_percentage')
                ->take(4);

            return view('dashboard', compact('lastTickets', 'flightsWithVacancies'));
        } elseif ($user && $user->hasRole('client')) {
            // Lógica para el cliente
            $lastTickets = Ticket::where('user_id', $user->id)->latest()->take(4)->get();
            $latestFlights = Flight::latest()->take(4)->get();

            return view('dashboard', compact('lastTickets', 'latestFlights'));
        }

        // Si no hay un usuario autenticado, redirigir al login
        return redirect()->route('home');
    }
}
