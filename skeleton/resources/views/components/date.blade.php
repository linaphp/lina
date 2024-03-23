@php
    $slot = \Carbon\Carbon::parse($slot)->format('F j, Y');
@endphp

<time class="text-sm">{{ $slot }}</time>
