<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
            'location' => 'nullable|string',
        ]);

        // Create the event for the authenticated user
        $event = auth()->user()->events()->create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'location' => $request->input('location'),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('events.index');
    }

    public function signUpForEvent($eventId)
    {
        $event = Event::findOrFail($eventId);

        // Attach the user to the event
        $event->attendees()->attach(auth()->id());

        return redirect()->route('events.show', $event);
    }

    public function index()
    {
        // List all events
        $events = Event::all();

        return view('events.index', compact('events'));
    }

    public function show($id)
    {
        // Retrieve the event by ID
        $event = Event::findOrFail($id);

        // Pass the event to the view
        return view('events.show', compact('event'));
    }

    // Show events the user is attending
    public function myEvents()
    {
        $events = auth()->user()->signedUpEvents;

        return view('events.myevents', compact('events'));
    }
}
