@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center py-5">
        <div class="col-md-5 mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-12 text-center">
                        <h4><i class="fas fa-meh-rolling-eyes"></i> {{ __('Reset Password') }}</h4>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" novalidate>
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

                        <div class="form-group mb-0">
                            <div class="col-12 ">
                                <button type="submit" class="btn btn-success btn-block">
                                    <i class="fas fa-check"></i> {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="form-group mb-0">
                            <div class="col-md-12 text-center">
                                <a class="btn btn-block btn-primary tx-tfm" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt"></i> Ingresar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
