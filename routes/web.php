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

Route::get('/events', [EventController::class, 'index'])->name('events.index');

// Route to show the create form
Route::get('/events/create', [EventController::class, 'create'])->name('events.create');

// Route to show a single event

// Route to store the event
Route::post('/events', [EventController::class, 'store'])->name('events.store');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show')->middleware('auth')->can('view', 'id');
    /*Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show')->middleware('auth')->can('view', Event::class);*/
});
