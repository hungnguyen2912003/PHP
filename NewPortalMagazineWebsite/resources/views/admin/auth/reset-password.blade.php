@extends('admin.auth.layout.master')

@section('title', 'Reset Password')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h4>{{ __('admin.reset_password.title') }}</h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.reset-password.post') }}">
            @csrf
            <div class="form-group">
                <label for="email">{{ __('admin.reset_password.email') }}</label>
                <input id="email" type="email" class="form-control" name="email" tabindex="1" autofocus value="{{ request()->email }}" placeholder="Enter your email" readonly>
                <input type="hidden" name="token" value="{{ request()->token }}">
                @error('email')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">{{ __('admin.reset_password.new_password') }}</label>
                <input id="password" type="password" class="form-control" name="password" tabindex="2" placeholder="Enter your new password">
                @error('password')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password-confirm">{{ __('admin.reset_password.confirm_password') }}</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" tabindex="2" placeholder="Confirm your new password">
                @error('password_confirmation')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection