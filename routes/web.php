<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\TicketController;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/home', function () {
    return view('home');})->name('home');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Ruta para mostrar la vista de vuelos
Route::get('/flights', [FlightController::class, 'index'])->name('flights');

// Ruta para obtener los datos de los vuelos (Yajra DataTables)
Route::get('/flights/data', [FlightController::class, 'getFlights'])->name('flights.getFlights');


Route::middleware('auth')->group(function () {

// Rutas para el CRUD de tickets
Route::get('/sales', [TicketController::class, 'index'])->name('sales');


// Rutas para el CRUD de usuarios
Route::get('/users', [UserController::class, 'index'])->name('users');
Route::get('/users/data', [UserController::class, 'getUserData'])->name('users.userDatatable');
Route::get('/admin/create-users', function () {return view('admin.create-users');})->name('create-users');
Route::patch('/admin/create-users', [UserController::class, 'userCreate'])->name('user-create');
Route::get('/admin/edit-users', [UserController::class, 'userEdit'])->name('edit-users');
Route::patch('/admin/edit-users', [UserController::class, 'userUpdate'])->name('user-update');
Route::delete('/admin/edit-users', [UserController::class, 'userDelete'])->name('user-delete');

Route::get('/sales/data', [TicketController::class, 'getMyTickets'])->name('sales.getTickets');


// Rutas para el perfil del usuario
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.edit');
Route::put('/profile/{user}', [ProfileController::class, 'updatePhoto'])->name('profile.update-photo');
Route::delete('/profile/{user}', [ProfileController::class, 'deletePhoto'])->name('profile.delete-photo');
Route::patch('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::put('password', [ProfileController::class, 'updatePassword'])->name('password.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
