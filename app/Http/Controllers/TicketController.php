<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Flight;
use App\Models\User;
use App\Http\Requests\TicketRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;



class TicketController extends Controller
{
    /**
     * Mostrar una lista de todos los tickets.
     */
    public function index()
    { $user = Auth::user();

        if ($user->hasRole('client')) {
            return view('usertickets');
        } else {
            return view('tickets');
        }

    }

    public function showUserTickets($userId)
    {
        $user = User::findOrFail($userId); // Obtén el usuario por su ID

        return view('usertickets', compact('user'));
    }


    /**
     * Mostrar el formulario para crear un nuevo ticket.
     */
    public function create()
    {
        $flights = Flight::all();  // Obtener todos los vuelos disponibles
        return view('purchase-form', compact('flights'));
    }

    /**
     * Almacenar un nuevo ticket en la base de datos.
     */
    public function store(TicketRequest $request, Flight $flight)
{

}



    // /**
    //  * Mostrar el formulario para editar un ticket existente.
    //  */
    // public function edit(Ticket $ticket)
    // {
    //     $flights = Flight::all();  // Obtener todos los vuelos disponibles
    //     return view('tickets.edit', compact('ticket', 'flights'));
    // }

    // /**
    //  * Actualizar un ticket existente en la base de datos.
    //  */
    // public function update(TicketRequest $request, Ticket $ticket)
    // {
    //     $data = $request->validated();
    //     $ticket->update($data);  // Actualizar el ticket
    //     $ticket->seats = $request->seats; // Actualizar los asientos
    //     $ticket->save();

    //     return redirect()->route('tickets')->with('success', 'Ticket actualizado exitosamente.');
    // }

    /**
     * Eliminar un ticket de la base de datos.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets')->with('success', 'Ticket eliminado exitosamente.');
    }





    /**
     * Mostrar la tarjeta de embarque de un ticket.
     */

    public function previewInvoice($id)
    {
        $ticket = Ticket::with(['user', 'flight.aircraft'])->findOrFail($id);
          // Decodificar los asientos del avión
    $seats = json_decode($ticket->flight->aircraft->seats, true);

        // Generar el código QR con el ID del ticket o cualquier otro dato
        $qrCode = QrCode::size(130)->generate(route('tickets.invoice', ['id' => $ticket->id]));

        // Renderiza una vista para previsualizar el contenido
        return view('preview-invoice', compact('ticket', 'qrCode'));
    }

    /**
     * Descargar el PDF de la factura de un ticket.
     */
    public function downloadInvoice($id)
    {
        $ticket = Ticket::with(['user', 'flight'])->findOrFail($id);

        // Renderiza la vista en un PDF
        $pdf = Pdf::loadView('preview-invoice', compact('ticket'));

        // Descargar el archivo
        return $pdf->download('invoice_ticket_' . $ticket->id . '.pdf');
    }



}
