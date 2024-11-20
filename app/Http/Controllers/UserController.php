<?php

namespace App\Http\Controllers;

use App\models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;




class UserController extends Controller
{
    public function index()
    {
        return view('users');
    }

    public function getUserData(Request $request)
    {
        if ($request->ajax()) {
            // Seleccionamos los usuarios y cargamos sus roles con `with('roles')`
            $users = User::select(['id', 'name', 'lastname', 'email', 'phone', 'created_at'])
                ->get();  // Podemos hacer la consulta directamente, ya que los roles se cargarán con el método `getRoleNames()`

            return DataTables::of($users)
                ->addColumn('full_name', function ($row) {
                    return $row->name . ' ' . $row->lastname;
                })
                ->addColumn('role', function ($row) {
                    // Usamos getRoleNames() para obtener los roles y unirlos en una cadena separada por comas
                    return $row->getRoleNames()->join(', ');  // Devuelve los roles separados por coma
                })
                ->addColumn('action', function ($row) {
                    return '<a href="/users/' . $row->id . '/edit" class="btn btn-sm btn-primary">Edit</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
