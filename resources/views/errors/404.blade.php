@extends('errors::illustrated-layout')

@section('code', '404')
@section('title', 'Página no encontrada')

@section('image')
    <div style="background-image: url({{ asset('/svg/404.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@section('message', 'Lo sentimos, la página que estás buscando no se pudo encontrar.')
