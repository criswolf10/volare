<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Support\Facades\Log;
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
        Log::info('page loaded', $request->all());
        if ($request->ajax()) {
            // Obtener todos los vuelos
            $flights = Flight::select(['code', 'aircraft', 'origin', 'destination', 'duration', 'price', 'seats', 'date', 'status'])
            ->when($request->has('code'), function ($query) use ($request)
            {
                $query->where('code', 'like', '%' . $request->name . '%');
            })

            ;

            return DataTables::of($flights)
                ->addColumn('action', function ($row) {
                    return '<a href="/flights/' . $row->id . '/edit" class="btn btn-sm btn-primary">Edit</a>';
                })
                ->editColumn('status', function ($row) {
                    return $row->status == 1 ? 'Activo' : '<h1>Inactivo</h1>';
                })
                ->rawColumns(['action']) // Asegura que la columna 'action' se renderice como HTML
                ->make(true);  // Regresa la respuesta en formato JSON para DataTables
        }
    }
}
