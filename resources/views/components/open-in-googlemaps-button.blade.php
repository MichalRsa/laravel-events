@props(['location'])

@php

    $url = 'https://www.google.com/maps/dir/?api=1&destination=' . $location;

@endphp


<a href="{{ $url }}" target="_blank" class="inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded">Open
    in Google Maps</a>
