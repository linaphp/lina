@extends('app')

@section('content')
    <h1 class="text-center">{{ $data->title }}</h1>
    <p class="text-center">This is a static blog build with PHP.</p>

    {!! $data->content !!}

    <hr>
    <div>
        <h2>Latest posts</h2>
        <ul style="list-style: none">
            @foreach(collect(cf()->index('posts'))->reverse() as $post)
                <li>
                    <span>{{ $post->createdAt }}</span>
                    <a href="{{ $post->url() }}" class="block" style="padding: 0.25rem 0;">{{ $post->title }} {{ $post->createdAt }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
