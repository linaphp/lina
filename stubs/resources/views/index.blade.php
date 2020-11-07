<x-layout>
	<ul>
		@foreach($posts as $post)
			<li>
				[{{ $post->created_at }}] <a href="{{ $post->link() }}">{{ $post->title }}</a>
			</li>
		@endforeach
	</ul>
</x-layout>
