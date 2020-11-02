@props(['title' => config('app.name')])
<html>
<head>
    {{ $title }}
</head>
<body>
    {{ $slot }}
</body>
</html>
