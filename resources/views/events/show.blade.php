<!-- resources/views/events/show.blade.php -->

<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-4 flex justify-between w-full items-center">

                <h1 class="text-4xl font-bold ">{{ $event->title }}</h1>
                <a href="{{ route('events.edit', $event->id) }}"
                    class="inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded">Edit</a>

            </div>
            <!-- Event Details -->
            <div class="text-gray-700">
                <p class="text-lg mb-4">
                    <strong>Description:</strong> {{ $event->description ?? 'No description provided.' }}
                </p>

                <p class="text-lg mb-4">
                    <strong>Start Time:</strong> {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y H:i') }}
                </p>

                @if ($event->end_time)
                    <p class="text-lg mb-4">
                        <strong>End Time:</strong> {{ \Carbon\Carbon::parse($event->end_time)->format('M d, Y H:i') }}
                    </p>
                @endif

                @if ($event->location)
                    <p class="text-lg mb-4">
                        <strong>Location:</strong> {{ $event->location }}
                    </p>
                @endif
            </div>
            <x-add-to-google-calendar-button :title="$event->title" :description="$event->description" :start_time="$event->start_time" :end_time='$event->end_time'
                :location='$event->location' />

            <x-open-in-googlemaps-button :location='$event->location' />
        </div>
    </div>
</x-app-layout>
