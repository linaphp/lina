@extends('layout')

@php
    $posts = collect(lina()->index('posts'))->sort(fn($a, $b) => $b->createdAt <=> $a->createdAt);
@endphp

@section('content')
    <h1 class="text-center">{{ $data->title }}</h1>

    {!! $data->content !!}

    <hr>
    <div>
        <h2>Latest posts</h2>
        <ul style="display: flex; flex-direction: column; gap: 1rem; list-style: none; padding: 0">
            @foreach($posts as $post)
                <li>
                    <x-date>{{ $post->createdAt }}</x-date>
                    <a href="{{ $post->url() }}" class="block"
                       style="padding: 0.25rem 0;">{{ $post->title }} {{ $post->createdAt }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
