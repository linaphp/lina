<x-layout>
	<ul>
		@foreach($posts as ['slug' => $slug, 'title' => $title, 'created_at' => $created_at])
			<li>
				[{{ $created_at }}] <a href="/posts/{{ $slug }}">{{ $title }}</a>
			</li>
		@endforeach
	</ul>
</x-layout>
