@extends('app')

@section('content')
    <h1 class="text-center">{{ $data->title }}</h1>

    <div>{{ $data->createdAt }}</div>
    <article>
        {!! $data->content !!}
    </article>
@endsection
