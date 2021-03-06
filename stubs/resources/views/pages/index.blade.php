<x-layout>
	<ul>
		@foreach($posts as $post)
			<li class="mb-3">
				<div class="text-sm">
					<time class="text-gray-500">[{{ $post->created_at }}]</time>
				</div>
				<a href="{{ $post->link() }}" class="text-red-500 hover:underline">{{ $post->title }}</a>
			</li>
		@endforeach
	</ul>
</x-layout>
