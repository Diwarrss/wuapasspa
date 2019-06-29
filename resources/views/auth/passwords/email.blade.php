@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center py-5">
        <div class="col-md-5 mx-auto">
            <div class="card">
                <div class="col-md-12 text-center py-3">
                    <div class="text-center">
                        <i class="fas fa-lock fa-3x"></i> 
                    </div>
                    <span>¿Tienes problemas para iniciar sesión?</span>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" novalidate>
                        @csrf
                        <div class="text-center py-2">
                            <span class="text-muted">Ingresa tu correo electrónico y te enviaremos un enlace para recuperar el acceso a tu cuenta.</span>
                        </div>
                        <div class="form-group row">
                            <div class="input-group col-md-12">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="{{ __('E-Mail Address') }}">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <div class="col-12 ">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-check"></i> Enviar enlace
                                </button>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="form-group mb-0">
                            <div class="col-md-12 text-center">
                                <span>
                                    <a class="mb-2 text-dark" href="{{ route('register') }}"><strong>Crea cuenta nueva</strong> </a>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <a class=" btn btn-outline-secondary tx-tfm text-dark" href="{{ route('login') }}">
                        <i class="fas fa-arrow-left"></i> Volver a inicio de sesión
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
