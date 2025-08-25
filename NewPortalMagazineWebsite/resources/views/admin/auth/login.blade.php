@extends('admin.auth.layout.master')

@section('title', 'Login')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h4>{{ __('admin.login.title') }}</h4>
    </div>

    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <form method="POST" action="{{ route('admin.login.post') }}" class="needs-validation" novalidate="">
            @csrf
            <div class="form-group">
                <label for="email">{{ __('admin.login.email') }}</label>
                <input id="email" type="email" class="form-control" name="email" tabindex="1" autofocus placeholder="Enter your email">
                @error('email')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <div class="d-block">
                    <label for="password" class="control-label">{{ __('admin.login.password') }}</label>
                    <div class="float-right">
                        <a href="{{ route('admin.forgot-password') }}" class="text-small">
                            {{ __('admin.login.forgot_password') }}
                        </a>
                    </div>
                </div>
                <input id="password" type="password" class="form-control" name="password" tabindex="2" placeholder="Enter your password">
                @error('password')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                    <label class="custom-control-label" for="remember-me">{{ __('admin.login.remember_me') }}</label>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    {{ __('admin.login.login') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection