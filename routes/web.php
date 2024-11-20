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

Route::get('/sales', [TicketController::class, 'index'])->name('sales');


Route::get('/sales', function () {
    return view('sales');
})->middleware(['auth', 'verified'])->name('sales');

Route::get('/users', [UserController::class, 'index']
)->middleware(['auth', 'verified'])->name('users');

Route::get('/users/data', [UserController::class, 'getUserData']
)->middleware(['auth', 'verified'])->name('users.getUserData');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{user}', [ProfileController::class, 'updatePhoto'])->name('profile.update-photo');
    Route::delete('/profile/{user}', [ProfileController::class, 'deletePhoto'])->name('profile.delete-photo');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
