@extends('layout', ['title' => $post->title])

@section('content')
    <h1>{{ $post->title }}</h1>
    <div>
        {!! $post->content !!}
    </div>
@endsection
