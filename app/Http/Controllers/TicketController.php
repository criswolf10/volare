<?php

namespace App\Http\Controllers;

use App\Http\Requests\PassengerRequest;
use App\Models\AircraftSeat;
use App\Models\Passenger;
use App\Models\Ticket;
use App\Models\Flight;
use App\Models\User;
use App\Http\Requests\TicketRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;



class TicketController extends Controller
{
    /**
     * Mostrar una lista de todos los tickets.
     */
    public function index()
    {
        $user = Auth::user();

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
    public function create($flightId)
    {
        // Obtener los datos del vuelo
        $flight = Flight::with('aircraft')->findOrFail($flightId);

        // Obtener las clases y asientos disponibles del avión asociado al vuelo
        $availableSeats = AircraftSeat::where('aircraft_id', $flight->aircraft_id)
            ->where('reserved', false)
            ->get()
            ->groupBy('class');

        return view('purchase', [
            'flight' => $flight,
            'availableSeats' => $availableSeats
        ]);
    }

    /**
     * Procesar la compra del ticket.
     */
    public function store(PassengerRequest $request, $flightId)
    {
        $flight = Flight::findOrFail($flightId);

        // Verificar autenticación
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes estar autenticado para comprar un billete.');
        }
        $userId = auth()->id();

        // Validar asiento
        $seat = AircraftSeat::where('seat_code', $request->seat_code)
            ->where('reserved', false)
            ->first();

        if (!$seat) {
            return back()->with('error', 'El asiento seleccionado ya está reservado .');
        }

        try {
            DB::beginTransaction();

            // Crear el pasajero en la tabla "passengers"
            $passenger = Passenger::create([
                'name' => $request->passenger_name,
                'lastname' => $request->passenger_lastname,
                'email' => $request->passenger_email,
                'phone' => $request->passenger_phone,
                'dni' => $request->passenger_document,
            ]);

            // Crear el código de reserva único
            $bookingCode = 'TKT' . Str::upper(Str::random(10));

            // Crear el ticket
            $ticket = Ticket::create([
                'user_id' => $userId,
                'passenger_id' => $passenger->id,
                'flight_id' => $flight->id,
                'aircraft_seat_id' => $seat->id,
                'booking_code' => $bookingCode,
                'quantity' => 1,
                'purchase_date' => now(),
            ]);
            dd($request->all());

            // Marcar el asiento como reservado
            $seat->update(['reserved' => true]);

            DB::commit();

            return redirect()->route('tickets.success', $ticket->id)
                ->with('success', 'Billete comprado exitosamente para el pasajero ' . $passenger->name);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un error al procesar la compra. Inténtalo de nuevo.');
        }
    }



    /**
     * Página de éxito.
     */
    public function purchaseSuccess($ticketId)
    {
        $ticket = Ticket::with(['flight', 'seat'])->findOrFail($ticketId);

        return view('ticket-success', compact('ticket'));
    }

    /**
     * Eliminar un ticket de la base de datos.
     */
    public function destroy(Ticket $ticket)
    {
        // Asegurarse de que el ticket tenga un vuelo y un avión asociado
        if (!$ticket->flight || !$ticket->flight->aircraft) {
            return back()->with('error', 'No se puede cancelar el billete porque el vuelo o el avión no existen.');
        }

        $aircraftStatus = $ticket->flight->aircraft->status;
        $departureDateTime = $ticket->flight->departure_date . ' ' . $ticket->flight->departure_time;

        // Verificar si el vuelo ya ha despegado
        if (now() >= $departureDateTime || $aircraftStatus === 'en_trayecto') {
            return back()->with('error', 'No se puede cancelar el billete porque el vuelo ya ha despegado o está en trayecto.');
        }

        try {
            DB::beginTransaction();

            // Liberar el asiento
            $ticket->seat->update(['reserved' => false]);

            // Eliminar pasajero si existe
            if ($ticket->passenger) {
                $ticket->passenger->delete();
            }

            // Eliminar el ticket
            $ticket->delete();

            DB::commit();

            // Verificar si se devolverá el dinero
            $daysToDeparture = now()->diffInDays($departureDateTime);
            $refundMessage = $daysToDeparture >= 7
                ? 'El billete ha sido cancelado y se reembolsará el dinero.'
                : 'El billete ha sido cancelado, pero no se reembolsará el dinero.';

            return redirect()->route('tickets.index')->with('success', $refundMessage);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un error al cancelar el billete.');
        }
    }

    //funcion para mostrar el formulario de cancelar ticket

    public function cancelTicket($ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);

        return view('ticket-cancelled', compact('ticket'));
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
