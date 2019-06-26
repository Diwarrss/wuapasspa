<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mayra Peluqueria') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/misLibrerias.css') }}" rel="stylesheet">
    <!-- Para que sea Full PWA -->
    @laravelPWA
</head>
<body style="background-image: linear-gradient(to bottom, #9937ae, #843eae, #6e43ad, #5846a9, #4148a4, #3e49a6, #3b49a8, #374aaa, #4b4ab4, #604abd, #7548c5, #8a44cb); background-repeat: no-repeat; background-attachment: fixed;">
    <div id="app">
        @include('navegacion2')

        <main class="py-4">
            <div class="flex-center position-ref full-height">
                @yield('content')
            </div>
        </main>
    </div>
    <!--Importando todos los Js del webpack vue y boostrap-->
    <script src="{{asset('js/misLibrerias.js')}}"></script>
    <script src="{{ asset('js/appCliente.js') }}"></script>
</body>
</html>
