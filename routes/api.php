<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\TicketsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.create');

Route::post('/bookings/{booking}/tickets', [TicketsController::class, 'store'])->name('tickets.create');

Route::post('/bookings/{booking}/invoices', [InvoicesController::class, 'store'])->name('invoices.create');
Route::get('/bookings/{booking}/current_invoice', [InvoicesController::class, 'current'])->name('invoices.current');
