<html>
<head>
    <title>{{ $title ?? config('app.name') }}</title>
</head>
<body>
@yield('content')
</body>
</html>
