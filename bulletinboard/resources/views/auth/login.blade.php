@extends('layouts.app')

@section('title','Login')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Login Form</h3>
                </div>

                <div class="card-body">

                    <form method="post" action="/user/login">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-md-3 col-form-label">Email</label>

                            <div class="col-sm-8 col-md-7">
                            <input type="text" name="email" id="email" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <label for="require" class="col-sm-1 col-md-2 col-form-label text-danger text-md-left">*</label>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-sm-3 col-md-3 col-form-label text-md-left">Password</label>

                            <div class="col-sm-8 col-md-7">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <label for="require" class="col-sm-1 col-md-1 col-form-label text-danger text-md-left">*</label>
                        </div>
                        @if(Session::has('incorrect'))
                            <div class="alert alert-danger">
                                {{ Session::get('incorrect') }}
                                @php
                                    Session::forget('incorrect');
                                @endphp
                            </div>
                        @endif
                        <div class="form-group row">
                            <div class="col-sm-6 col-md-6 offset-sm-4 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-sm-8 col-md-8 offset-sm-4 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        Forgot Your Password?
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
