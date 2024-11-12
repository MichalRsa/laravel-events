@php
    use Carbon\Carbon;
@endphp

<x-app-layout>

    <div x-data="{ showModal: false, selectedDate: null, selectedEvents: [] }" @keydown.escape="showModal = false">

        <div class="container mx-auto p-6">
            <div class="flex justify-end mb-6">
                <a href="{{ route('events.create') }}"
                    class="inline-block bg-blue-500 text-white py-2 px-4 rounded h-fit">
                    Create New
                </a>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex justify-center items-center mb-4 gap-12">
                    <a href="{{ route('events.calendar', ['month' => Carbon::create($currentYear, $currentMonth)->subMonth()->month, 'year' => Carbon::create($currentYear, $currentMonth)->subMonth()->year]) }}"
                        class="inline-block bg-blue-500 text-white py-2 px-4 rounded">
                        Previous Month
                    </a>
                    <h2 class="text-xl font-semibold">
                        {{ Carbon::create($currentYear, $currentMonth, 1)->format('F Y') }}
                    </h2>

                    <a href="{{ route('events.calendar', ['month' => Carbon::create($currentYear, $currentMonth)->addMonth()->month, 'year' => Carbon::create($currentYear, $currentMonth)->addMonth()->year]) }}"
                        class="inline-block bg-blue-500 text-white py-2 px-4 rounded">
                        Next Month
                    </a>
                </div>

                <div class="calendar-grid">
                    {{-- Week days header --}}
                    <div class="mb-2 grid grid-cols-7 gap-1">
                        @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $weekDay)
                            <div class=" text-center font-medium text-gray-600 py-2">{{ $weekDay }}</div>
                        @endforeach
                    </div>

                    {{-- Calendar days --}}
                    <div class="calendar-days grid grid-cols-7 gap-1">
                        {{-- Empty cells before the first day --}}
                        @for ($i = 0; $i < $startingDay; $i++)
                            <div class=" p-2 border border-gray-100 bg-gray-50"></div>
                        @endfor

                        {{-- Days of the month --}}
                        @for ($day = 1; $day <= $daysInMonth; $day++)
                            {{-- Day content --}}
                            <div
                                class="p-2 min-h-[100px] border border-gray-200 relative {{ Carbon::create($currentYear, $currentMonth, $day)->isToday() ? 'bg-blue-50' : '' }}">
                                <div
                                    class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center">
                                    {{ $day }}</div>


                                @if (isset($events[$day]))
                                    <div>
                                        @foreach ($events[$day]->take(3) as $event)
                                            <a href="{{ route('events.show', $event->id) }}">
                                                <div class="my-1 text-xs p-1 bg-blue-100 text-blue-800 rounded truncate cursor-pointer"
                                                    title="{{ $event->title }}">
                                                    {{ $event->title }}
                                                </div>
                                            </a>
                                        @endforeach

                                        @if ($events[$day]->count() > 3)
                                            <button class="my-1 text-xs p-1 bg-blue-300 rounded truncate"
                                                @click="showModal = true;
                     selectedDate = '{{ Carbon::create($currentYear, $currentMonth, $day)->format('F d, Y') }}';
                     selectedEvents = {{ isset($events[$day]) ? $events[$day] : '[]' }}">
                                                <p class="text-xs text-gray-800">
                                                    +{{ $events[$day]->count() - 3 }} more
                                                </p>
                                            </button>
                                        @endif
                                    </div>
                                @endif

                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal --}}
        <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg max-w-lg w-full">
                <h3 class="text-lg font-semibold" x-text="selectedDate"></h3>
                <div class="mt-4">
                    <template x-for="event in selectedEvents" :key="event.id">
                        <a :href="`/events/${event.id}`" class="hover:bg-blue-100 p-5 rounded inline-block w-full">
                            <div x-text="event.title" class="font-medium"></div>
                            <div x-text="event.description" class="text-sm text-gray-600"></div>
                        </a>
                    </template>
                </div>
                <button @click="showModal = false" class="inline-block bg-blue-500 text-white py-2 px-4 rounded mt-4">
                    Close
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
