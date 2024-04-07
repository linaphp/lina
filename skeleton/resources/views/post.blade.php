@extends('layout')

@section('content')
    <h1 class="text-center">{{ $data->title }}</h1>
    <time>{{ $data->createdAt }}</time>

    <article>
        {!! $data->content !!}
    </article>
@endsection
