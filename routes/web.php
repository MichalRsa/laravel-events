<?php

use App\Http\Controllers\EventController;
use App\Models\Event;
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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/calendar', [EventController::class, 'calendar'])->name('events.calendar');

    // Route to show the create form
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');

    // Route to show a single event

    // Route to store the event
    Route::post('/events', [EventController::class, 'store'])->name('events.store');

    Route::post('/events/{event}/register', [EventController::class, 'register'])->name('events.register');
    Route::post('/events/{event}/cancel', [EventController::class, 'cancelRegistration'])->name('events.cancel');

    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');

    Route::patch('/events/{event}', [EventController::class, 'update'])->name('events.update');

    Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show')->middleware('auth')->can('view', 'id');

});
