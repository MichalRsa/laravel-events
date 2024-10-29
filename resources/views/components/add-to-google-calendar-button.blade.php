@props(['title', 'description', 'start_time', 'end_time', 'location'])

@php

    use Carbon\Carbon;

    $baseUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE&';

    $start = Carbon::parse($start_time)->format('Ymd\THis\Z');
    $end = Carbon::parse($end_time)->format('Ymd\THis\Z');

    $fullUrl =
        $baseUrl .
        'text=' .
        $title .
        '&' .
        'details=' .
        $description .
        '&' .
        'dates=' .
        $start .
        '/' .
        $end .
        '&' .
        'location=' .
        $location;

@endphp


<a href="{{ $fullUrl }}" target="_blank" class="inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded">Add to Google Calendar</a>
