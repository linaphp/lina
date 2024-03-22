<x-layout :title="$data['title']">

    <h1 class="text-red-500 text-4xl">{{ $data['title'] }}</h1>

    <div class="mt-5 leading-7 post-content">
        {!! $data['content'] !!}
    </div>
</x-layout>
