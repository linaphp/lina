@extends('layout', ['title' => 'Home page'])

@section('content')
    <h1>Home page</h1>

    <ul>
        @foreach($posts as $post)
            <li><a href="/{{ $post['slug'] }}">[{{ $post['created_at'] }}] {{ $post['title'] }}</a></li>
        @endforeach
    </ul>
@endsection
