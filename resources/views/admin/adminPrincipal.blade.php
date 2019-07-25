<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Para que sea Full PWA -->
    @laravelPWA
    @if (Auth::check())
        <script src="{{ asset('js/enable-push.js') }}" defer></script>           
    @endif

    @if(Auth::user()->roles_roles_id == 1)<!-- si es administrador-->
        <title>Admin - {{ config('app.name')}}</title>
    @elseif(Auth::user()->roles_roles_id == 2)<!-- si es empleado-->
        <title>Empleado - {{ config('app.name')}}</title>
    @elseif(Auth::user()->roles_roles_id == 4)<!-- si es agendador-->
        <title>Agendador - {{ config('app.name')}}</title>
    @endif
    <!-- Todos los css se importan de aqui todos con webpack -->
    <link type="text/css" rel="stylesheet" href="{{asset('css/adminlte.css')}}">
    <!-- Estilo personalizado sweetalert-->
    <style>
        .swal2-popup {
            font-size: 1.5rem !important;
            }
        .swal2-icon {
            font-size: 1.5rem !important;
            }
    </style>
</head>
<body class="hold-transition sidebar-mini skin-purple fixed">

    <div id="app">
        <div class="wrapper">

            <!-- Aqui se llama el header y navbar que va a tener el panel admin -->
            @include('admin.navbar')

            <!-- Se llamara el panel de navegacion izquierdo dependiendo del rol -->
            <!-- validar auth sesion -->
            @if(Auth::check())<!-- si esta autenticado el usuario actual-->
                @if(Auth::user()->roles_roles_id == 1)<!-- si es administrador-->
                    <navegacionadmin></navegacionadmin>
                @elseif(Auth::user()->roles_roles_id == 2)<!-- si es empleado-->
                    <navegacionempleado></navegacionempleado>
                @elseif(Auth::user()->roles_roles_id == 4)<!-- si es empleado-->
                    <navegacionagendador></navegacionagendador>
                @endif
            @endif

            <!-- Content Wrapper. Contains page content --->
            {{--@include('admin.contenido')---}}

            <!-- Content Wrapper. Contains page content Contenido agregado con Vue Router-->
            <router-view></router-view>

            <!-- /Footer del contenido -->
            @include('admin.footer')

        </div>
    </div>
    <!--Importando todos los Js del webpack el primero es solo vuejs-->
    <script src="{{asset('js/adminlte.js')}}"></script>
    <script src="js/appAdmin.js"></script>
</body>
</html>
