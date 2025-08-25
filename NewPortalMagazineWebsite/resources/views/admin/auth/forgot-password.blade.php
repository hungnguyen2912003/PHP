@extends('admin.auth.layout.master')

@section('title', 'Forgot Password')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h4>{{ __('admin.forgot_password.title') }}</h4>
    </div>

    <div class="card-body">
        <p class="text-muted">{{ __('admin.forgot_password.description') }}</p>
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <form method="POST" action="{{ route('admin.forgot-password.post') }}">
            @csrf
            <div class="form-group">
                <label for="email">{{ __('admin.forgot_password.email') }}</label>
                <input id="email" type="email" class="form-control" name="email" tabindex="1" autofocus placeholder="Enter your email">
                @error('email')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    {{ __('admin.forgot_password.send_reset_password_link') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection