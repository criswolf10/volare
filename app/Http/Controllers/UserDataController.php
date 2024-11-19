<?php

namespace App\Http\Controllers;

use App\models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class UserDataController extends Controller
{
    public function index()
    {
        return view('users');
    }
    public function getUserData( Request $request)
    {
        if ($request->ajax()) {
            $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at']);

            return DataTables::of($users)
                ->addColumn('action', function ($row) {
                    return '<a href="/users/' . $row->id . '/edit" class="btn btn-sm btn-primary">Edit</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
}
}
