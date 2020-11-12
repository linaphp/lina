<!DOCTYPE html>
<html>
<head>
	<title>{{ $title ?? 'Home page' }}</title>

    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body>
	{{ $slot }}
</body>
</html>
