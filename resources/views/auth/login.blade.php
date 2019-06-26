@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center py-5">
        <div class="col-md-5 mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-12 text-center">
                        <h4><i class="fas fa-sign-in-alt"></i> Login</h4>
                    </div>
                </div>

                <div class="card-body">
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
                                <button type="submit" class="btn btn-block btn-primary tx-tfm">
                                    <i class="fas fa-sign-in-alt"></i> Ingresar
                                </button>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link text-primary" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="form-group mb-0">
                            <div class="col-md-12 text-center">
                                <a class="btn btn-block btn-outline-danger" href="{{ route('register') }}">
                                    <i class="fas fa-plus-circle"></i> Registrarme
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{--@include('partials.auth.social_login')--}}
    </div>
</div>
@endsection
