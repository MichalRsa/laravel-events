<!-- resources/views/events/index.blade.php -->

<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">All Events</h1>

        @if ($events->isEmpty())
            <p class="text-gray-500">No events available at the moment.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($events as $event)
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <h2 class="text-xl font-semibold mb-2">{{ $event->title }}</h2>

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
                        </p>

                        <a href="{{ route('events.show', $event->id) }}"
                            class="inline-block bg-blue-500 text-white py-2 px-4 rounded">
                            View Details
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
