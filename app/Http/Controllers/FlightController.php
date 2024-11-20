<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FlightController extends Controller
{
    public function index()
    {

        // Pasamos los vuelos a la vista
        return view('flights');
    }

    public function getFlights(Request $request)
    {

        if ($request->ajax()) {
            // Obtener todos los vuelos
            $flights = Flight::select(['code', 'aircraft', 'origin', 'destination', 'duration', 'price', 'seats', 'date', 'status']);

            return DataTables::of($flights)
                // Agregar columna con precio formateado
                ->editColumn('price', function ($row) {
                    $formatter = new \NumberFormatter('es_ES', \NumberFormatter::CURRENCY);
                    return $formatter->formatCurrency($row->price, 'EUR');
                })
                ->addColumn('action', function ($row) {
                    return '<a href="/flights/' . $row->id . '/edit" class="btn btn-sm btn-primary">Edit</a>';
                })
                ->editColumn('status', function ($row) {
                    return $row->status == 'borrador' ? 'Activo' : '<h1>Inactivo</h1>';
                })
                ->rawColumns(['action', 'status']) // Asegura que la columna 'action' se renderice como HTML
                ->make(true);  // Regresa la respuesta en formato JSON para DataTables
        }
    }
}
