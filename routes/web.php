<?php

use App\Http\Controllers\Datatables\FlightDatatable;
use App\Http\Controllers\Datatables\TicketDatatable;
use App\Http\Controllers\Datatables\UserDatatable;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/home', function () {
    return view('home');
})->name('home');




Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');



    // Listar vuelos
    Route::get('/flights', [FlightController::class, 'index'])->name('flights');

    // Obtener datos para DataTable
    Route::get('/flights/data', [FlightDatatable::class, 'getFlightData'])->name('flights.flightDatatable');

Route::middleware(['auth'])->group(function () {


    // Mostrar formulario para crear un vuelo
    Route::get('/admin/create-flights', [FlightController::class, 'create'])->name('flights.create');

    // Guardar nuevo vuelo
    Route::post('/admin/create-flights', [FlightController::class, 'store'])->name('flights.store');

    // Mostrar formulario para editar un vuelo
    Route::get('/admin/edit-flights/{id}', [FlightController::class, 'edit'])->name('edit.flights');

    // Actualizar un vuelo
    Route::patch('/admin/edit-flights/{id}', [FlightController::class, 'update'])->name('flights.update');

    // Eliminar un vuelo
    Route::delete('/admin/edit-flights/{id}', [FlightController::class, 'destroy'])->name('flights.delete');
});

Route::get('/purchase-ticket', [TicketController::class, 'create'])->name('tickets.create');
Route::post('/purchase-ticket', [TicketController::class, 'store'])->name('tickets.purchase');

Route::middleware(['auth'])->group(function () {
    // Rutas para el CRUD de tickets
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets');
    Route::get('/tickets/data', [TicketDatatable::class, 'getTicketsData'])->name('tickets.ticketDatatable');



});

Route::middleware(['auth'])->group(function () {
    // Rutas para el CRUD de usuarios
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/data', [UserDatatable::class, 'getUserData'])->name('users.userDatatable');
    Route::get('/admin/create-users', function () {
        return view('admin.create-users');
    })->name('create-users');
    Route::patch('/admin/create-users', [UserController::class, 'userCreate'])->name('user-create');
    Route::get('/admin/edit-users/{id}', [UserController::class, 'userEdit'])->name('edit-users');
    Route::patch('/admin/edit-users/{id}', [UserController::class, 'userUpdate'])->name('user-update');
    Route::delete('/admin/edit-users/{id}', [UserController::class, 'destroy'])->name('user-delete');
});


// Rutas para el perfil del usuario
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.edit');
Route::put('/profile/{user}', [ProfileController::class, 'updatePhoto'])->name('profile.update-photo');
Route::delete('/profile/{user}', [ProfileController::class, 'deletePhoto'])->name('profile.delete-photo');
Route::patch('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::put('password', [ProfileController::class, 'updatePassword'])->name('password.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');




require __DIR__ . '/auth.php';
