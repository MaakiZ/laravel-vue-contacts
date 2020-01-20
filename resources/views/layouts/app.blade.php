<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        
        <title>Meus Contatos</title>
        <meta name="description" content="Lista de contatos">
        
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="icon" type="image/ico" href="{{ asset('img/favicon.ico') }}">
    </head>
    <body>
        <div id="app">
            @yield('content')
        </div>

        <script src="{{ url('js/app.js') }}"></script>
    </body>
</html>