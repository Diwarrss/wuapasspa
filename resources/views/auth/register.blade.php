@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center py-3">
        <div class="col-md-5 mx-auto">
            <div class="text-center py-3">
                <img src="/img/perfiles/Logo-GridSoft.png" height="35">
            </div> 
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12 text-center py-3">
                        <span class="text-muted"><i class="far fa-id-card"></i> Regístrate para apartar tu cita ya!</span>
                    </div>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('register') }}" novalidate>
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="nombres" type="text" class="form-control{{ $errors->has('nombres') ? ' is-invalid' : '' }}" name="nombres" value="{{ old('nombres') }}" required autofocus placeholder="Nombres">

                                @if ($errors->has('nombres'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nombres') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="apellidos" type="text" class="form-control{{ $errors->has('apellidos') ? ' is-invalid' : '' }}" name="apellidos" value="{{ old('apellidos') }}" required placeholder="Apellidos">

                                @if ($errors->has('apellidos'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('apellidos') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row"  style="display: none;">
                            <div class="col-md-12">
                                <input id="usuario" type="text" class="form-control{{ $errors->has('usuario') ? ' is-invalid' : '' }}" name="usuario" value="{{ old('usuario') }}" required placeholder="Usuario Login">

                                @if ($errors->has('usuario'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('usuario') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="E-mail">

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Contraseña">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirma contraseña">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="celular" type="text" class="form-control{{ $errors->has('celular') ? ' is-invalid' : '' }}" name="celular" value="{{ old('celular') }}" required placeholder="Número WhatsApp">

                                @if ($errors->has('celular'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('celular') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input type="text" onfocus="(this.type='date')" placeholder="Fecha Cumpleaños" name="fechaCumple" value="{{ old('fechaCumple') }}" required class="form-control" id="fechaCumple" data-toggle="datetimepicker" data-target="#fechaCumple"/>
                                @if ($errors->has('fecha_cumpleaños'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('fecha_cumpleaños') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-block btn-primary">
                                    <i class="far fa-save"></i> Registrarme
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="py-3">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <div class="col-md-12 text-center">
                                ¿Tienes una cuenta?
                                <a class="mb-2" href="{{ route('login') }}">Entrar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--@include('partials.auth.social_login')--}}
    </div>
</div>
@endsection
