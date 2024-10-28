@php
    use Carbon\Carbon;
@endphp

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
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-center mb-4">
                <h2 class="text-xl font-semibold">
                    {{ Carbon::create($currentYear, $currentMonth, 1)->format('F Y') }}
                </h2>
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
                        <div
                            class="p-2 min-h-[100px] border border-gray-200 relative {{ Carbon::create($currentYear, $currentMonth, $day)->isToday() ? 'bg-blue-50' : '' }}">
                            <div class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center">
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
                                        <div class="text-xs text-gray-500 mt-1">
                                            +{{ $events[$day]->count() - 3 }} more
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
