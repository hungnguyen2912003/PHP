@extends('admin.layouts.admin-layout')

@section('title', 'Add User')

@section('content')

<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Add User</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.users') }}">User</a>
                </li>
                <li class="breadcrumb-item active">
                    Add User
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-12">
                            <h5 class="form-title">
                                <span
                                    >User
                                    Information</span
                                >
                            </h5>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div
                                class="form-group local-forms"
                            >
                                <label
                                    >User ID
                                    <span
                                        class="login-danger"
                                        >*</span
                                    ></label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                />
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div
                                class="form-group local-forms"
                            >
                                <label
                                    >Subject Name
                                    <span
                                        class="login-danger"
                                        >*</span
                                    ></label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                />
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div
                                class="form-group local-forms"
                            >
                                <label
                                    >Class
                                    <span
                                        class="login-danger"
                                        >*</span
                                    ></label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                />
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="student-submit">
                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection