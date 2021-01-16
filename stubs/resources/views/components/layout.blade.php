<!DOCTYPE html>
<html>
<head>
	<title>{{ $title ?? 'Home page' }}</title>

	<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@400&display=swap" rel="stylesheet">
	<style>
		html, body {
			font-family: 'Inconsolata', monospace;
		}
		a {
			color: green;
		}
		a:hover {
			text-decoration: underline;
		}
		.post-content p {
			padding: 1rem 0;
		}
	</style>
</head>
<body>
	<div class="pl-2 pt-2 max-w-xl">

		<x-navbar />

		<div class=" pt-5">
			{{ $slot }}
		</div>
	</div>
</body>
</html>
