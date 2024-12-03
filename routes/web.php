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

// Rutas para el CRUD de vuelos
Route::get('/flights', [FlightController::class, 'index'])->name('flights');
Route::get('/flights/data', [FlightController::class, 'getFlightData'])->name('flights.flightDatatable');
Route::get('/admin/create-flights', function () {return view('admin.create-flights');})->name('create-flights');
Route::patch('/admin/create-flights', [UserController::class, 'flightCreate'])->name('flight-create');



Route::middleware(['auth'])->group(function () {
    // Rutas para el CRUD de tickets
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets');
    Route::get('/tickets/data', [TicketController::class, 'getTicketsData'])->name('tickets.ticketDatatable');
});

Route::middleware(['auth'])->group(function () {
// Rutas para el CRUD de usuarios
Route::get('/users', [UserController::class, 'index'])->name('users');
Route::get('/users/data', [UserController::class, 'getUserData'])->name('users.userDatatable');
Route::get('/admin/create-users', function () {return view('admin.create-users');})->name('create-users');
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




require __DIR__.'/auth.php';
