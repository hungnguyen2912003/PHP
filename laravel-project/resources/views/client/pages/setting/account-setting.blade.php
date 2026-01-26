@extends('client.layouts.client-layout')

@section('title', 'Account')

@section('content')
<div class="main-content-container overflow-hidden">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">
            Settings
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
                    <span class="text-secondary">Settings</span>
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
        <form>
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">First Name</label>
                        <div class="form-floating">
                            <input class="form-control" id="floatingInput1" type="text" value="Mateo"/>
                            <label for="floatingInput1">First name</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">Last Name</label>
                        <div class="form-floating">
                            <input class="form-control" id="floatingInput2" type="text" value="Luca"/>
                            <label for="floatingInput2">Last name</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">Email Address</label>
                        <div class="form-floating">
                            <input class="form-control" id="floatingInput3" type="text" value="mateo@StarCode.com"/>
                            <label for="floatingInput3">Email address</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">Phone Number</label>
                        <div class="form-floating">
                            <input class="form-control" id="floatingInput4" type="text" value="+(555) 555-1234"/>
                            <label for="floatingInput4">Phone number</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">Location</label>
                        <div class="form-floating">
                            <input class="form-control" id="floatingInput5" type="text" value="Zuichi, Switzerland"/>
                            <label for="floatingInput5">Location</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">Street Address</label>
                        <div class="form-floating">
                            <input class="form-control" id="floatingInput6" type="text" value="2445 Crosswind Drive"/>
                            <label for="floatingInput6">Street address</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">Date Of Birth</label>
                        <div class="form-floating">
                            <input class="form-control" id="floatingInput7" type="text" value="20 March 1999"/>
                            <label for="floatingInput7">Date of birth</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">Gender</label>
                        <div class="form-floating">
                            <select aria-label="Floating label select example" class="form-select form-control" id="floatingSelect8">
                                <option selected="">Male</option>
                                <option value="1">Select</option>
                                <option value="2">Female</option>
                                <option value="2">Custom</option>
                            </select>
                            <label for="floatingSelect8">Select</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">Add Your Bio</label>
                        <div class="form-floating">
                            <textarea class="form-control" id="floatingTextarea9" placeholder="Write here...." style="height: 152px"></textarea>
                            <label for="floatingTextarea9">Write here</label>
                        </div>
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
                                <input class="form__file bottom-0" id="upload-files" multiple="multiple" type="file"/>
                                </label>
                            </div>
                        </div>
                        <div id="files-list-container"></div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="mb-20">
                        <h3 class="fs-22">Socials Profile</h3>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">Facebook</label>
                        <div class="form-floating">
                            <input class="form-control" id="floatingInput9" type="text" value="https://www.facebook.com/"/>
                            <label for="floatingInput9">Facebook</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">Twitter</label>
                        <div class="form-floating">
                            <input class="form-control" id="floatingInput10" type="text" value="https://twitter.com/"/>
                            <label for="floatingInput10">Twitter</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">Linkedin</label>
                        <div class="form-floating">
                            <input class="form-control" id="floatingInput11" type="text" value="https://www.instagram.com/"/>
                            <label for="floatingInput11">Linkedin</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary fw-normal text-white" type="button">Updated Profile</button>
                        <button class="btn btn-danger fw-normal text-white" data-bs-dismiss="modal" type="button">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
