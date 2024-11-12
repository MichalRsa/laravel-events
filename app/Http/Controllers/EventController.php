<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function create(): View|Factory
    {
        return view('events.create');
    }

    public function store(Request $request): RedirectResponse
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
            'team_id' => $request->user()->currentTeam->id, // Assign the current team ID
        ]);

        return redirect()->route('events.index');
    }

    public function edit(Event $event): Redirector|RedirectResponse|View
    {
        return view('events.edit', ['event' => $event]);
    }

    public function update(Event $event): Redirector|RedirectResponse
    {
        request()->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
            'location' => 'nullable|string',
        ]);

        // Create the event for the authenticated user
        $event->update([
            'title' => request('title'),
            'description' => request('description'),
            'start_time' => request('start_time'),
            'end_time' => request('end_time'),
            'location' => request('location'),
        ]);

        return redirect()->route('events.show', $event);
    }

    public function signUpForEvent($eventId): RedirectResponse
    {
        $event = Event::findOrFail($eventId);

        // Attach the user to the event
        $event->attendees()->attach(auth()->id());

        return redirect()->route('events.show', $event);
    }

    public function index(): View|Factory
    {
        // List all events
        $userCurrentTeam = auth()->user()->current_team_id;

        $events = Event::where('team_id', $userCurrentTeam)->orderBy('start_time', 'asc')->get();

        return view('events.index', compact('events'));
    }

    public function calendar(Request $request): View|Factory
    {
        $today = Carbon::today();

        $currentMonth = $request->get('month', Carbon::now()->month);
        $currentYear = $request->get('year', Carbon::now()->year);

        // Get all days in the current month
        $daysInMonth = Carbon::now()->daysInMonth;
        $firstDayOfMonth = Carbon::create($currentYear, $currentMonth, 1);
        $startingDay = $firstDayOfMonth->dayOfWeek;

        // Get events for the current month (assuming you have Event model)
        $userCurrentTeam = auth()->user()->current_team_id;

        $events = Event::whereMonth('start_time', $currentMonth)
            ->whereYear('start_time', $currentYear)
            ->where('team_id', $userCurrentTeam)
            ->orderBy('start_time', 'asc')
            ->get()
            ->groupBy(function ($event) {
                return Carbon::parse($event->start_time)->day;
            });

        return view('events.calendar', compact('today', 'daysInMonth', 'startingDay', 'events', 'currentMonth', 'currentYear'));
    }

    public function show(Event $id): View|Factory
    {
        // Retrieve the event by ID
        $event = Event::findOrFail($id->id);

        // Pass the event to the view
        return view('events.show', compact('event'));
    }

    // Show events the user is attending
    public function myEvents(): View|Factory
    {
        $events = auth()->user()->signedUpEvents;

        return view('events.myevents', compact('events'));
    }

    // Method to sign up the user for an event
    public function register(Event $event): RedirectResponse
    {
        $user = Auth::user();
        /*dd($user->signedUpEvents());*/

        // Check if the user is already registered
        if (! $user->signedUpEvents->contains($event->id)) {
            $user->signedUpEvents()->attach($event->id);  // Add to pivot table
        }

        return redirect()->route('events.show', $event)->with('success', 'You have registered for the event.');
    }

    // Method to cancel the registration
    public function cancelRegistration(Event $event): RedirectResponse
    {
        $user = Auth::user();

        // Check if the user is already registered
        if ($user->signedUpEvents->contains($event->id)) {
            $user->signedUpEvents()->detach($event->id);  // Remove from pivot table
        }

        return redirect()->route('events.show', $event)->with('success', 'You have canceled your registration.');
    }
    public function destroy(Event $event): Redirector|RedirectResponse
    {
        $event->delete();

        return redirect('/events/');
    }

}
