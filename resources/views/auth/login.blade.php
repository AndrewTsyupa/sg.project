@extends('layouts.default')

@section('title', 'Логін')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card bg-secondary shadow border-0">
            <div class="card-body px-lg-5 py-lg-5">
                <div class="text-center text-muted mb-4">
                    <span class="nav-link-inner--text">Login</span>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                            </div>
                            <input id="email" type="email" placeholder="Email"
                                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                   name="email" value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                            class="ni ni-lock-circle-open"></i></span>
                            </div>
                            <input id="password" type="password" placeholder="Password"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                   name="password" required>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="text-center">

                        <button type="submit" class="btn btn-primary my-4">
                            {{ __('Login') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
        <div class="row mt-3">
            <div class="col-6">
                <a href="#" class="text-light">
                    <small>Forgot password?</small>
                </a>
            </div>
            <div class="col-6 text-right">
                <a href="#" class="text-light">
                    <small>Create new account</small>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection