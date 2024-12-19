<?php

use App\Http\Controllers\Datatables\FlightsDatatable;
use App\Http\Controllers\Datatables\LastTicketsUserDatatable;
use App\Http\Controllers\Datatables\TicketsDatatable;
use App\Http\Controllers\Datatables\UsersDatatable;
use App\Http\Controllers\Datatables\UserTicketsDatatable;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AircraftController;


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
Route::get('/flights/data', [FlightsDatatable::class, 'getFlightData'])->name('flights.flightsDatatable');

Route::middleware(['auth'])->group(function () {
    // Mostrar formulario para crear un vuelo
    Route::get('/admin/create-flights', [FlightController::class, 'create'])->name('flights.create');
    // Guardar nuevo vuelo
    Route::post('/admin/create', [FlightController::class, 'store'])->name('flights.store');
    // Mostrar formulario para editar un vuelo
    Route::get('/admin/edit-flights/{id}', [FlightController::class, 'edit'])->name('edit.flights');
    // Actualizar un vuelo
    Route::patch('/admin/edit-flights/{id}', [FlightController::class, 'update'])->name('flights.update');
    // Eliminar un vuelo
    Route::delete('/admin/edit-flights/{id}', [FlightController::class, 'destroy'])->name('flights.delete');

    // Formulario para crear un avion
    Route::get('/admin/create-aircrafts', [AircraftController::class, 'create'])->name('aircrafts.create');
    // Guardar un avion
    Route::post('/admin/create-aircrafts', [AircraftController::class, 'store'])->name('aircrafts.store');
});



Route::middleware(['auth'])->group(function () {
    // Rutas para el CRUD de tickets
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets');
    Route::get('/tickets/data', [TicketsDatatable::class, 'getTicketsData'])->name('tickets.ticketsDatatable');
    Route::get('/myticket/data', [LastTicketsUserDatatable::class, 'getLastTicketsUser'])->name('tickets.LastTicketsUserDatatable');
    Route::get('/user-tickets', [UserTicketsDatatable::class, 'getUserTickets'])->name('datatables.userTickets');
    Route::get('/user-tickets/{userId}', [TicketController::class, 'showUserTickets'])->name('user-tickets');
    Route::delete('/cancel/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.delete');
    Route::get('/cancel/tickets/{ticketId}', [TicketController::class, 'cancelTicket'])->name('cancel-ticket');
    Route::get('/purchase-ticket/{flightId}', [TicketController::class, 'create'])->name('tickets.purchase');
    Route::post('/create-ticket/{flightId}', [TicketController::class, 'store'])->name('tickets.processPurchase');
    Route::get('/tickets/success/{ticketId}', [TicketController::class, 'purchaseSuccess'])->name('tickets.success');
});

Route::middleware(['auth'])->group(function () {
    // Rutas para el CRUD de usuarios
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/data', [UsersDatatable::class, 'getUserData'])->name('users.usersDatatable');
    Route::get('/admin/create-users', [UserController::class, 'create'])->name('create-users');
    Route::patch('/admin/create-users', [UserController::class, 'store'])->name('user-create');
    Route::get('/admin/edit-users/{id}', [UserController::class, 'edit'])->name('edit-users');
    Route::patch('/admin/edit-users/{id}', [UserController::class, 'update'])->name('user-update');


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
