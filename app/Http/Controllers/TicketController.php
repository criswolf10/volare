<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Flight;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("sales");
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'flight_code' => ['required', 'exists:flights,code'],
            'quantity' => ['required', 'integer'],
            'purchase_date' => ['required', 'date'],
        ]);

        $flight = Flight::where('code', $validated['flight_code'])->first();

        if (!$flight) {
            return response()->json(['error' => 'El vuelo no existe.'], 404);
        }

        // Crear el ticket
        $ticket = Ticket::create($validated);

        return response()->json([
            'message' => 'Ticket comprado exitosamente.',
            'ticket' => $ticket,
        ], 201);
    }





    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }







}
