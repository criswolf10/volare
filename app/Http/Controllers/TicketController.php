<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $sales = Ticket::with(['user', 'flight'])->get();
        return view('sales', compact('sales'));
    }

    
}

