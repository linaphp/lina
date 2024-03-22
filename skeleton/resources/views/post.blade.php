<x-layout :title="$title">

    <h1 class="text-red-500 text-4xl">{{ $title }}</h1>

    <div class="mt-5 leading-7 post-content">
        {!! $content !!}
    </div>
</x-layout>
