@extends('admin.layouts.master')

@section('title', 'Profile')

@section('content')
<div class="section-header">
    <h1>{{ __('admin.navbar.profile') }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">{{ __('admin.navbar.dashboard') }}</a></div>
        <div class="breadcrumb-item">{{ __('admin.navbar.profile') }}</div>
    </div>
</div>
<div class="section-body">
    <h2 class="section-title">Hi, {{ auth()->guard('admin')->user()->name }}!</h2>
    <p class="section-lead">
        {{ __('admin.profile.description') }}
    </p>
    <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-7">
            <div class="card">
                <form method="post" action="{{ route('admin.profile.update', auth()->guard('admin')->user()->id) }}" class="needs-validation" novalidate="" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h4>{{ __('admin.profile.update_profile') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label>{{ __('admin.profile.name') }}</label>
                                    <input type="text" class="form-control" name="name" value="{{ auth()->guard('admin')->user()->name }}" placeholder="Enter your name">
                                    @error('name')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>{{ __('admin.profile.email') }}</label>
                                    <input type="email" class="form-control" name="email" value="{{ auth()->guard('admin')->user()->email }}" placeholder="Enter your email">
                                    @error('email')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label>{{ __('admin.profile.image') }}</label>
                                    <div id="image-preview" class="image-preview">
                                        <label for="image-upload" id="image-label">{{ __('admin.profile.choose_file') }}</label>
                                        <input type="file" name="image" id="image-upload" class="image-input" accept="image/*" />
                                    </div>
                                    @error('image')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary">{{ __('admin.profile.update_profile') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-5">
            <div class="card">
                <form method="post" action="{{ route('admin.profile.update-password', auth()->guard('admin')->user()->id) }}" class="needs-validation" novalidate="">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h4>{{ __('admin.profile.update_password') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-12">
                                <label>{{ __('admin.profile.current_password') }}</label>
                                <input type="password" class="form-control" name="current_password" value="" placeholder="Enter your current password">
                                @error('current_password')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-12">
                                <label>{{ __('admin.profile.new_password') }}</label>
                                <input type="password" class="form-control" name="new_password" value="" placeholder="Enter your new password">
                                @error('new_password')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-12">
                                <label>{{ __('admin.profile.confirm_password') }}</label>
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
                        <button class="btn btn-primary">{{ __('admin.profile.update_password') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.image-preview').css({
            "background-image": "url({{ asset(auth()->guard('admin')->user()->image) }})",
            "background-size": "cover",
            "background-position": "center center",
            "background-repeat": "no-repeat"
        });
    });
</script>
@endpush