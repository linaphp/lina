@extends('layout', ['title' => $title])

@section('content')
    <h1>{{ $title }}</h1>
    <div>
        {!! $content !!}
    </div>
@endsection
