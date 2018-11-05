@extends('layouts.default')

@section('title', 'Home Page')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card bg-secondary shadow border-0">
                <div class="card-body px-lg-5 py-lg-5">
                    <div class="text-center text-muted mb-4">
                        <span class="nav-link-inner--text">Register</span>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <div class="input-group input-group-alternative">
                                <input id="name" placeholder="Name" type="text"
                                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <input id="email" placeholder="Email" type="email"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       name="email"
                                       value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <input id="password" placeholder="Password" type="password"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <input id="password-confirm" placeholder="Password Confirmation" type="password"
                                       class="form-control"
                                       name="password_confirmation" required>
                            </div>

                        </div>

                        <div class="text-center">

                            <button type="submit" class="btn btn-primary my-4">
                                {{ __('Register') }}
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