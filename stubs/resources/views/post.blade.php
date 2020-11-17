<x-layout :title="$post->title">

    <h1 class="text-red-500 text-4xl">{{ $post->title }}</h1>

    <div class="mt-5 leading-7 post-content">
        {!! $post->content !!}
    </div>
</x-layout>
