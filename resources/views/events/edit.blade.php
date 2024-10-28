<!-- resources/views/events/create.blade.php -->

<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Create New Event</h1>

        <!-- Display validation errors, if any -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form to create a new event -->
        <form action="{{ route('events.update', $event->id) }}" method="POST" class="space-y-6">
            @csrf <!-- CSRF protection token -->
            @method('PATCH')


            <!-- Event Title -->
            <div>
                <label for="title" class="block text-lg font-medium">Event Title</label>
                <input type="text" name="title" id="title" value="{{ $event->title }}"
                    class="form-input mt-1 block w-full border border-gray-300 rounded-lg p-2" required>
            </div>

            <!-- Event Description -->
            <div>
                <label for="description" class="block text-lg font-medium">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="form-textarea mt-1 block w-full border border-gray-300 rounded-lg p-2">{{ $event->description }}</textarea>
            </div>

            <!-- Event Start Time -->
            <div>
                <label for="start_time" class="block text-lg font-medium">Start Time</label>
                <input type="datetime-local" name="start_time" id="start_time" value="{{ $event->start_time }}"
                    class="form-input mt-1 block w-full border border-gray-300 rounded-lg p-2" required>
            </div>

            <!-- Event End Time -->
            <div>
                <label for="end_time" class="block text-lg font-medium">End Time</label>
                <input type="datetime-local" name="end_time" id="end_time" value="{{ $event->end_time }}"
                    class="form-input mt-1 block w-full border border-gray-300 rounded-lg p-2">
                <small class="text-gray-500">End time is optional, but must be after the start time if provided.</small>
            </div>

            <!-- Event Location -->
            <div>
                <label for="location" class="block text-lg font-medium">Location</label>
                <input type="text" name="location" id="location" value="{{ $event->location }}"
                    class="form-input mt-1 block w-full border border-gray-300 rounded-lg p-2">
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Edit
                    Event</button>
            </div>
        </form>
    </div>
</x-app-layout>
