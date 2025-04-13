<!Doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>@yield('title')</title>
    @yield('css')
</head>
<body>
    <section id='head'>

    </section>

    <section id='content'>
        @yield('content')

    </section>

    <section id='footer'>

    </section>

    <section id='script'>
        @yield('script')
    </section>
</body>
