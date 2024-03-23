@extends('app')

@section('content')
    <h1 class="text-center">{{ $data->title }}</h1>

    <time>{{ $data->createdAt }}</time>
    <article>
        {!! $data->content !!}
{{--        {{ $data->content }}--}}
    </article>
@endsection
