<!-- resources/views/events/index.blade.php -->

<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="flex justify-between mb-6">
            <div class="flex items-center  gap-4">
                <h1 class="text-3xl font-bold ">All Events</h1>
                <a href="{{ route('events.calendar') }}" class="inline-block bg-blue-500 text-white py-2 px-4 rounded">
                    Calendar View
                </a>
            </div>

            <a href="{{ route('events.create') }}" class="inline-block bg-blue-500 text-white py-2 px-4 rounded h-fit">
                Create New
            </a>
        </div>

        @if ($events->isEmpty())
            <p class="text-gray-500">No events available at the moment.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($events as $event)
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <h2 class="text-xl font-semibold mb-2">{{ $event->title }}</h2>
                        <div class="flex items-center">

                            <img class="h-8 w-8 rounded-full object-cover mr-4"
                                src="{{ $event->user->profile_photo_url }}" alt="{{ $event->user->name }}" />
                            <p>{{ $event->user->name }}</p>
                        </div>

                        <p class="text-gray-700 mb-4">
                            {{ Str::limit($event->description, 100) }}
                        </p>

                        <p class="text-gray-500 text-sm mb-4">
                            <strong>Starts:</strong>
                            {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y H:i') }} <br>
                            @if ($event->end_time)
                                <strong>Ends:</strong>
                                {{ \Carbon\Carbon::parse($event->end_time)->format('M d, Y H:i') }}
                            @endif
                        </p>

                        <p class="text-gray-500 text-sm mb-4">
                            @if ($event->location)
                                <strong>Location:</strong> {{ $event->location }}
                            @endif
                            @if (!$event->attendees)
                                No one signed up, yet.
                            @else
                                <div class="flex items-center">

                                    <ul class="flex my-4">
                                        @foreach ($event->attendees->take(4) as $attendee)
                                            <li class="mr-2"><img class="h-8 w-8 rounded-full object-cover"
                                                    src="{{ $attendee->profile_photo_url }}" alt=""></li>
                                        @endforeach
                                    </ul>
                                    @if ($event->attendees->count() - 4 > 0)
                                        <p>{{ $event->attendees->count() - 4 > 0 }} more</p>
                                    @endif

                                </div>
                            @endif
                        </p>

                        <a href="{{ route('events.show', $event->id) }}"
                            class="inline-block bg-blue-500 text-white py-2 px-4 rounded">
                            View Details
                        </a>
                        @if (!(Auth::user()->id === $event->user_id))
                            @if (Auth::user()->signedUpEvents->contains($event->id))
                                <form action="{{ route('events.cancel', $event) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Cancel
                                        Registration</button>
                                </form>
                            @else
                                <form action="{{ route('events.register', $event) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Register
                                        for
                                        Event</button>
                                </form>
                            @endif
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
