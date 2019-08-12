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
                    {{-- <div class="text-center py-2">
                        @foreach ($logoEmpresa as $item)
                        <img src="/img/perfiles/{{$item->logo_empresa}}" height="60" style="border: medium">
                        @endforeach
                    </div> --}}
                    <form method="POST" action="{{ route('login') }}" novalidate>
                        @csrf
                        <div class="form-group row">
                            <div class="input-group col-md-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-at"></i></span>
                                </div>
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="{{ __('E-Mail Address') }}">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="input-group col-md-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-unlock-alt"></i></span>
                                </div>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="{{ __('Password') }}">
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-block btn-primary tx-tfm mb-2">
                                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                                </button>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        @if (Route::has('password.request'))
                        <div class="col-md-12 text-center">
                            <a class="btn btn-link text-primary" href="{{ route('password.request') }}">
                                ¿Has olvidado la contraseña?
                            </a>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
            <div class="py-3">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <div class="col-md-12 text-center">
                                <span>¿No tienes una cuenta?
                                    <a class="mb-2" href="{{ route('register') }}">Registrate</a>
                                </span>
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
