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
<body style="background-image: linear-gradient(to right top, #4c73b1, #577dbb, #6286c5, #6d90cf, #789ad9, #71a2df, #6aaae3, #64b2e7, #4eb8e2, #42bdd8, #45c1cc, #55c4bd);
        background-repeat: no-repeat; background-attachment: fixed;">
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
