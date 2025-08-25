@extends('admin.auth.layout.master')

@section('title', 'Forgot Password')

@section('content')
<div class="login-brand">
    <img src="{{ asset('admin/img/stisla-fill.svg') }}" alt="logo" width="100" class="shadow-light rounded-circle">
</div>

<div class="card card-primary">
    <div class="card-header">
        <h4>Forgot Password</h4>
    </div>

    <div class="card-body">
        <p class="text-muted">We will send a link to reset your password</p>
        <form method="POST" action="{{ route('admin.forgot-password.post') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    Forgot Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection