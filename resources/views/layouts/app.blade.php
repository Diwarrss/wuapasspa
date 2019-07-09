<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Sitio web para solicitar mi Cita para ser atendido." />
    <meta name="keywords" content="San Gil, Agendar, Pagina Web" />

    <title>{{ config('app.name', "Wuapa's Spa") }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/misLibrerias.css') }}" rel="stylesheet">
    <!-- Para que sea Full PWA -->
    @laravelPWA
    @if (Auth::check())
        <script src="{{ asset('js/enable-push.js') }}" defer></script>           
    @endif
</head>
<body style="background-image: linear-gradient(to bottom, #9937ae, #843eae, #6e43ad, #5846a9, #4148a4, #3e49a6, #3b49a8, #374aaa, #4b4ab4, #604abd, #7548c5, #8a44cb); background-repeat: no-repeat; background-attachment: fixed;">
    <div id="app">
        @include('navegacion2')

        <main class="py-4">
            <div class="flex-center position-ref full-height">
                @yield('content')
            </div>
        </main>
        <footer class="footer mt-auto py-3">
            <div class="">
                <div class="card">
                    <div class="card-body">
                        <div class="align-center">
                            © Copyright 2019 <a href="https://www.gridsoft.co/" target="_blank">www.gridsoft.co</a> All Rights Reserved
                        </div>
                    </div>            
                </div>
            </div>
        </footer>
    </div>
    
    <!--Importando todos los Js del webpack vue y boostrap-->
    <script src="{{asset('js/misLibrerias.js')}}"></script>
    <script src="{{ asset('js/appCliente.js') }}"></script>
</body>
</html>
