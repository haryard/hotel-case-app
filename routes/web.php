<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomTypeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['role:admin', 'auth', 'verified'])->group(function() {
    Route::get('/room', [RoomController::class, 'index'])->name('room.index');
    Route::get('/room/create', [RoomController::class, 'create'])->name('room.create');
    Route::get('/room/{room}/edit', [RoomController::class, 'edit'])->name('room.edit');
    Route::get('/room/{room}', [RoomController::class, 'destroy'])->name('room.destroy');
    Route::get('/room-type/create', [RoomTypeController::class, 'create'])->name('room-type.create');
    Route::get('/room-type/{roomType}/edit', [RoomTypeController::class, 'edit'])->name('room-type.edit');
    Route::get('/room-type/{roomType}', [RoomTypeController::class, 'destroy'])->name('room-type.destroy');
    Route::get('/report', function() { return view('report'); })->name('report.index');
});

Route::middleware(['role:user', 'auth', 'verified'])->group(function() {
    Route::get('/reservation', [ReservationController::class, 'index'])->name('reservation.index');
    Route::get('/reservation/create', [ReservationController::class, 'create'])->name('reservation.create');
    Route::get('/reservation/{transaction}/view', [ReservationController::class, 'show'])->name('reservation.show');
    Route::get('/reservation/{transaction}', [ReservationController::class, 'destroy'])->name('reservation.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
