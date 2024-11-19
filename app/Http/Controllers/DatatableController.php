<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class DatatableController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at']);
            return DataTables::of($users)->make(true);
        }

        return view('users.index');
    }
}
