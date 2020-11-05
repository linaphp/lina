<x-layout>
	<ul>
		@foreach($posts as $post)
			<li>
				[{{ $post->created_at }}] <a href="/posts/{{ $post->slug }}">{{ $post->title }}</a>
			</li>
		@endforeach
	</ul>
</x-layout>
