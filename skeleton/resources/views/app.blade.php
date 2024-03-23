<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ implode(' | ', [$data->title ?? '', 'My awesome blog']) }}</title>
    <meta name="description" content="{{ substr(strip_tags($data->content), 0, 165) }}">

    <meta >

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/style.css">
</head>
<body>
<div id="app">
    <header class="container">
        <nav class="main-menu">
            <a href="/">Home</a>
            <a href="/about">About</a>
        </nav>
    </header>

    <main class="container">
        @yield('content')
    </main>
</div>
</body>
</html>
