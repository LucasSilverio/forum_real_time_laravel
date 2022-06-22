<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=@, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>

    <link rel="stylesheet" href="/css/app.css" />
</head>
<body>
    <header>
        @include('layouts.default.header')
    </header>
    <main>
        <section id="app">
            @yield('content')
        </section>
    </main>
    @include('layouts.default.footer')

    @component('layouts.default.body_scripts')
        @yield('scripts')
    @endcomponent
</body>
</html>