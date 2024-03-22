@extends('app')

@section('content')
    <h1 class="text-center">Welcome to my blog</h1>

    <div class="mt-5">
        <p class="text-center">This is a static blog build with PHP.</p>
    </div>

    <div>
        <h2>Latest posts</h2>


        <ul>
            @foreach(cf()->index('posts') as $post)
                <li>
                    <a href="{{ $post->url() }}">{{ $post->title }}</a>
                </li>
            @endforeach
            <li></li>
        </ul>
    </div>
@endsection
