@extends('admin.layouts.master')

@section('title', 'Profile')

@section('content')
<div class="section-header">
    <h1>Profile</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">Profile</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Hi, {{ auth()->guard('admin')->user()->name }}!</h2>
    <p class="section-lead">
        Change information about yourself on this page.
    </p>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-6">
            <div class="card">
                <form method="post" action="{{ route('admin.profile.update', auth()->guard('admin')->user()->id) }}" class="needs-validation" novalidate="">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h4>Update Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" value="{{ auth()->guard('admin')->user()->name }}" placeholder="Enter your name">
                                @error('name')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="{{ auth()->guard('admin')->user()->email }}" placeholder="Enter your email">
                                @error('email')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-6">
            <div class="card">
                <form method="post" action="{{ route('admin.profile.update-password', auth()->guard('admin')->user()->id) }}" class="needs-validation" novalidate="">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h4>Update Password</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-12">
                                <label>Current Password</label>
                                <input type="password" class="form-control" name="current_password" value="" placeholder="Enter your current password">
                                @error('current_password')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-12">
                                <label>New Password</label>
                                <input type="password" class="form-control" name="new_password" value="" placeholder="Enter your new password">
                                @error('new_password')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-12">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" name="confirm_password" value="" placeholder="Enter your confirm password">
                                @error('confirm_password')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection