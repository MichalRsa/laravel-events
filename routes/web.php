<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

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

Route::get('/events', [EventController::class, 'index'])->name('events.index');

// Route to show a single event
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');

// Route to store the event
Route::post('/events', [EventController::class, 'store'])->name('events.store');

// Route to show the create form
Route::get('/events/create', [EventController::class, 'create'])->name('events.create');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
