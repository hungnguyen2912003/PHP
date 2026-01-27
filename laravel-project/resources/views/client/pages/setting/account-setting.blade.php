@extends('client.layouts.client-layout')

@section('title', 'Setting Account')

@section('content')
<div class="main-content-container overflow-hidden">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">
            Setting Account
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a class="d-flex align-items-center text-decoration-none" href="/">
                    <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                    <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li aria-current="page" class="breadcrumb-item active">
                    <span class="text-secondary">Setting Account</span>
                </li>
            </ol>
        </nav>
    </div>
    <div class="card bg-white border border-white rounded-10 p-20 mb-4">
        <ul class="ps-0 mb-4 list-unstyled d-flex flex-wrap gap-2 gap-lg-3">
            <li>
                <a class="btn btn-primary border-primary bg-primary text-white fs-16 fw-normal px-3 px-lg-4" href="{{ route('setting.account') }}">Account Settings</a>
            </li>
            <li>
                <a class="btn btn-primary border-border-color-70 bg-transparent text-secondary fs-16 fw-normal px-3 px-lg-4" href="{{ route('setting.change-password') }}">Change Password</a>
            </li>
        </ul>
        <div class="mb-20">
            <h3 class="mb-1 fs-22">Profile</h3>
            <p class="fs-16 lh-1-8">
                Update your photo and personal details here.
            </p>
        </div>
        <form action="{{ route('setting.account.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">Full Name</label>
                        <div class="form-floating">
                            <input class="form-control @error('fullname') is-invalid @enderror" id="floatingInput1" name="fullname" type="text" placeholder="Full Name" value="{{ old('fullname', $user->fullname) }}"/>
                            <label for="floatingInput1">Full name</label>
                        </div>
                        @error('fullname')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">Gender</label>
                        <div class="form-floating">
                            <select aria-label="Floating label select example" class="form-select form-control @error('gender') is-invalid @enderror" id="floatingSelect8" name="gender">
                                <option value="" {{ old('gender', $user->gender) == '' ? 'selected' : '' }}>Select</option>
                                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <label for="floatingSelect8">Select</label>
                        </div>
                        @error('gender')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">Email Address</label>
                        <div class="form-floating">
                            <input class="form-control @error('email') is-invalid @enderror" id="floatingInput3" name="email" type="text" placeholder="Email Address" value="{{ old('email', $user->email) }}"/>
                            <label for="floatingInput3">Email address</label>
                        </div>
                        @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">Phone Number</label>
                        <div class="form-floating">
                            <input class="form-control @error('phone') is-invalid @enderror" id="floatingInput4" name="phone" type="text" placeholder="Phone Number" value="{{ old('phone', $user->phone) }}"/>
                            <label for="floatingInput4">Phone number</label>
                        </div>
                        @error('phone')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">Address</label>
                        <div class="form-floating">
                            <input class="form-control @error('address') is-invalid @enderror" id="floatingInput5" name="address" type="text" placeholder="Address" value="{{ old('address', $user->address) }}"/>
                            <label for="floatingInput5">Address</label>
                        </div>
                        @error('address')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">Date Of Birth</label>
                        <div class="form-floating">
                            <input class="form-control @error('date_of_birth') is-invalid @enderror" id="floatingInput6" name="date_of_birth" type="text" placeholder="Date of Birth" value="{{ old('date_of_birth', $user->date_of_birth) }}"/>
                            <label for="floatingInput6">Date of birth</label>
                        </div>
                        @error('date_of_birth')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">Add Your Bio</label>
                        <div class="form-floating">
                            <textarea class="form-control @error('bio') is-invalid @enderror" id="floatingTextarea7" name="bio" placeholder="Write here...." style="height: 152px" maxlength="255">{{ old('bio', $user->bio) }}</textarea>
                            <label for="floatingTextarea7">Write here</label>
                        </div>
                        @error('bio')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="mb-20">
                        <h3 class="mb-1 fs-22">Your Photo</h3>
                        <p class="fs-16 lh-1-8">This will be displayed on your profile.</p>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group mb-4 only-file-upload" id="file-upload">
                        <div class="form-control h-100 text-center position-relative p-4 p-lg-5">
                            <div class="product-upload">
                                <label class="file-upload mb-0">
                                <i class="ri-folder-image-line bg-primary bg-opacity-10 p-2 rounded-1 text-primary">
                                </i>
                                <span class="d-block text-body fs-14">Drag and drop an image or Browse</span>
                                </label>
                                <label class="position-absolute top-0 bottom-0 start-0 end-0 cursor" id="upload-container">
                                <input class="form__file bottom-0" id="upload-files" name="avatar_url_file" multiple="multiple" type="file"/>
                                </label>
                            </div>
                        </div>
                        @error('avatar_url_file')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                        <div id="files-list-container"></div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary fw-normal text-white" type="submit">Updated Profile</button>
                        <a href="{{ route('profile') }}" class="btn btn-danger fw-normal text-white">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
