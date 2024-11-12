<!-- resources/views/events/show.blade.php -->

<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-4 flex justify-between w-full items-center">

                <h1 class="text-4xl font-bold ">{{ $event->title }}</h1>
                @can('update', $event)
                    <a href="{{ route('events.edit', $event->id) }}"
                        class="inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded">Edit</a>
                @endcan
            </div>
            <!-- Event Details -->
            <div class="text-gray-700">
                <p class="text-lg mb-4">
                    {{ $event->description ?? 'No description provided.' }}
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
                <div>
                    @if ($event->attendees->count() == 0)
                        <p class="pb-4 leading-8">
                            No one signed up, yet.
                        </p>
                    @else
                        <h2 class="font-bold text-lg mb-1">Atteendes: </h2>
                        <div class="flex items-center mb-4">

                            <ul class="flex flex-wrap gap-2">
                                @foreach ($event->attendees as $attendee)
                                    <li>
                                        <a href="{{ route('users.show', $attendee->id) }}"
                                            class="flex items-center py-1 px-2 border border-blue-500 rounded-lg hover:bg-blue-500 hover:cursor-pointer"><img
                                                class="h-8 w-8 rounded-full object-cover"
                                                src="{{ $attendee->profile_photo_url }}" alt="">
                                            <p class="pl-2">{{ $attendee->name }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    @endif
                </div>
                <x-add-to-google-calendar-button :title="$event->title" :description="$event->description" :start_time="$event->start_time" :end_time='$event->end_time'
                    :location='$event->location' />

                <x-open-in-googlemaps-button :location='$event->location' />
            </div>
        </div>
</x-app-layout>
