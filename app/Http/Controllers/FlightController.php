<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
    public function store(Request $request) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Flight $flight) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Flight $flight) {}

    public function getFlightData(Request $request)
    {
        if ($request->ajax()) {
            // Crear la consulta base para los vuelos
            $query = Flight::select(['code', 'aircraft', 'origin', 'destination', 'duration', 'price', 'seat_class', 'departure_date', 'status']);

            //  Obtener los datos de los vuelos
            $flights = $query->get();

            // Devolver los datos a DataTables

            return DataTables::of($flights)
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">Editar</a>';
                    $btn = $btn . ' <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Eliminar</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);


        }
}
}
