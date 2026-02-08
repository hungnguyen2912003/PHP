@extends('client.layouts.app-layout')

@section('title', __('title.account'))

@section('content')
    <div class="main-content-container overflow-hidden">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
            <h3 class="mb-0">{{ __('title.account') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb align-items-center mb-0 lh-1">
                    <li class="breadcrumb-item">
                        <a class="d-flex align-items-center text-decoration-none" href="/">
                            <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                            <span class="text-body fs-14 hover">{{ __('breadcrumb.dashboard') }}</span>
                        </a>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span class="text-secondary">{{ __('title.account') }}</span>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="card bg-white border border-white rounded-10 p-20 mb-4">
            <ul class="ps-0 mb-4 list-unstyled d-flex flex-wrap gap-2 gap-lg-3">
                <li>
                    <a class="btn btn-primary border-primary bg-primary text-white fs-16 fw-normal px-3 px-lg-4"
                        href="{{ route('client.settings.account') }}">{{ __('title.account') }}</a>
                </li>
                <li>
                    <a class="btn btn-primary border-border-color-70 bg-transparent text-secondary fs-16 fw-normal px-3 px-lg-4"
                        href="{{ route('client.settings.change-password') }}">{{ __('breadcrumb.settings.change_password') }}</a>
                </li>
            </ul>
            <div class="mb-20">
                <h4 class="fw-semibold fs-18 mb-sm-0">{{ __('title.account') }}</h4>
                <p class="fs-16 lh-1-8">
                    {{ __('section.account_desc') }}
                </p>
            </div>
            <form action="{{ route('client.settings.account.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-20">
                            <label class="form-label text-secondary">{{ __('label.full_name') }}</label>
                            <div class="form-floating">
                                <input class="form-control @error('fullname') is-invalid @enderror" id="floatingInput1"
                                    name="fullname" type="text" placeholder="{{ __('placeholder.full_name') }}"
                                    value="{{ old('fullname', $user->fullname) }}" />
                                <label for="floatingInput1"><i class="ri-user-line"></i>
                                    {{ __('placeholder.full_name') }}</label>
                            </div>
                            @error('fullname')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-20">
                            <label class="form-label text-secondary">{{ __('label.email') }}</label>
                            <div class="form-floating">
                                <input class="form-control @error('email') is-invalid @enderror" id="floatingInput3"
                                    name="email" type="text" placeholder="{{ __('placeholder.email') }}"
                                    value="{{ old('email', $user->email) }}" disabled />
                                <label for="floatingInput3"><i class="ri-mail-line"></i>
                                    {{ __('placeholder.email') }}</label>
                            </div>
                            @error('email')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-20">
                            <label class="form-label text-secondary">{{ __('label.gender') }}</label>
                            <div class="form-floating">
                                <select aria-label="Floating label select example"
                                    class="form-select form-control @error('gender') is-invalid @enderror"
                                    id="floatingSelect8" name="gender">
                                    <option value="" {{ old('gender', $user->gender) == '' ? 'selected' : '' }}>
                                        {{ __('placeholder.gender') }}
                                    </option>
                                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>
                                        {{ __('value.gender.male') }}
                                    </option>
                                    <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>
                                        {{ __('value.gender.female') }}
                                    </option>
                                    <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>
                                        {{ __('value.gender.other') }}
                                    </option>
                                </select>
                                <label for="floatingSelect8"><i class="ri-user-line"></i>
                                    {{ __('placeholder.gender') }}</label>
                            </div>
                            @error('gender')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-20">
                            <label class="form-label text-secondary">{{ __('label.phone') }}</label>
                            <div class="form-floating">
                                <input class="form-control @error('phone') is-invalid @enderror" id="floatingInput4"
                                    name="phone" type="text" placeholder="{{ __('placeholder.phone') }}"
                                    value="{{ old('phone', $user->phone) }}" />
                                <label for="floatingInput4"><i class="ri-phone-line"></i>
                                    {{ __('placeholder.phone') }}</label>
                            </div>
                            @error('phone')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-20">
                            <label class="form-label text-secondary">{{ __('label.address') }}</label>
                            <div class="form-floating">
                                <input class="form-control @error('address') is-invalid @enderror" id="floatingInput5"
                                    name="address" type="text" placeholder="{{ __('placeholder.address') }}"
                                    value="{{ old('address', $user->address) }}" />
                                <label for="floatingInput5"><i class="ri-map-pin-line"></i>
                                    {{ __('placeholder.address') }}</label>
                            </div>
                            @error('address')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-20">
                            <label class="form-label text-secondary">{{ __('label.date_of_birth') }}</label>
                            <div class="form-group position-relative">
                                <input
                                    class="form-control h-55 text-dark ps-5 h-58 @error('date_of_birth') is-invalid @enderror"
                                    type="date" name="date_of_birth"
                                    value="{{ old('date_of_birth', $user->date_of_birth) }}" />
                                <i
                                    class="ri-calendar-line position-absolute top-50 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                            @error('date_of_birth')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-20">
                            <label class="label fs-16 mb-2">{{ __('label.bio') }}</label>

                            <div class="form-floating">
                                <textarea class="form-control @error('bio') is-invalid @enderror" id="floatingTextarea7"
                                    name="bio" placeholder="{{ __('placeholder.bio') }}" style="height: 152px"
                                    maxlength="255">{{ old('bio', $user->bio) }}</textarea>

                                <label for="floatingTextarea7">
                                    <i class="ri-pencil-line"></i> {{ __('placeholder.bio') }}
                                </label>
                            </div>

                            {{-- Bộ đếm ký tự --}}
                            <div class="text-end small mt-1">
                                <span id="bioCount">0</span>/255
                            </div>

                            @error('bio')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="d-flex gap-2 justify-content-center">
                            <button class="btn btn-primary fw-normal text-white"
                                type="submit">{{ __('button.update') }}</button>
                            <a href="{{ route('client.profile.index') }}"
                                class="btn btn-danger fw-normal text-white">{{ __('button.cancel') }}</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const textarea = document.getElementById("floatingTextarea7");
            const counter = document.getElementById("bioCount");
            const maxLength = parseInt(textarea.getAttribute("maxlength"));

            function updateBioCounter() {
                if (textarea.value.length > maxLength) {
                    textarea.value = textarea.value.substring(0, maxLength);
                }
                counter.textContent = textarea.value.length;
            }

            textarea.addEventListener("input", updateBioCounter);

            updateBioCounter();
        });
    </script>

@endsection