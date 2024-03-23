<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ implode(' | ', [$data->title ?? '', 'My awesome blog']) }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=jost:300,300i,400,400i,500,500i,600,700&display=swap"
          rel="stylesheet"/>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
<div class="container" id="app">
    <header>
        <nav class="main-menu">
            <a href="/">Home</a>
            <a href="/about">About</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>
</div>
</body>
</html>
