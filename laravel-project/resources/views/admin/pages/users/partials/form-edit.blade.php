<form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-4">
            <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                <label class="label fs-16">
                    {{ __('common.info.user_image.title') }}
                </label>
                <div class="text-center">
                    <img src="{{ $user->avatar_url ? asset($user->avatar_url) : asset('assets/images/user.png') }}"
                        class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;" alt="user">
                </div>
            </div>
            <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                <div class="row">
                    <h3 class="mb-20">
                        {{ __('common.section.account_information') }}
                    </h3>
                    <div class="col-lg-12">
                        <div class="mb-20">
                            <label class="label fs-16 mb-2">
                                {{ __('common.info.username.title') }}
                            </label>
                            <div class="form-floating">
                                <input class="form-control" value="{{ $user->username }}" disabled type="text" />
                                <label>
                                    {{ __('common.info.username.title') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-20">
                            <label class="label fs-16 mb-2">
                                {{ __('common.info.password.title') }}
                            </label>
                            <div class="form-floating">
                                <input class="form-control @error('password') is-invalid @enderror" name="password"
                                    placeholder="{{ __('common.info.password.placeholder') }}" type="password" />
                                <label>
                                    {{ __('common.info.password.placeholder') }}
                                </label>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <small class="text-muted">{{ __('common.info.password.min_length') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                <h3 class="mb-20">
                    {{ __('common.section.profile_information') }}
                </h3>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-20">
                            <label class="label fs-16 mb-2">
                                {{ __('common.info.full_name.title') }} <span class="text-danger">*</span>
                            </label>
                            <div class="form-floating">
                                <input class="form-control @error('fullname') is-invalid @enderror" name="fullname"
                                    value="{{ old('fullname', $user->fullname) }}"
                                    placeholder="{{ __('common.info.full_name.placeholder') }}" type="text" />
                                <label>
                                    {{ __('common.info.full_name.placeholder') }}
                                </label>
                                @error('fullname')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-20">
                            <label class="label fs-16 mb-2">
                                {{ __('common.info.gender.title') }}
                            </label>
                            <select class="form-select form-control @error('gender') is-invalid @enderror" name="gender"
                                aria-label="Default select example">
                                <option value="" selected disabled>{{ __('common.info.gender.select') }}
                                </option>
                                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>
                                    {{ __('common.info.gender.title_male') }}
                                </option>
                                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>
                                    {{ __('common.info.gender.title_female') }}
                                </option>
                                <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>
                                    {{ __('common.info.gender.title_other') }}
                                </option>
                            </select>
                            @error('gender')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-20">
                            <label class="label fs-16 mb-2">
                                {{ __('common.info.date_of_birth.title') }}
                            </label>
                            <div class="form-floating">
                                <input class="form-control @error('date_of_birth') is-invalid @enderror"
                                    name="date_of_birth"
                                    value="{{ old('date_of_birth', optional($user->date_of_birth)->format('Y-m-d')) }}"
                                    type="date" />
                                <label>
                                    {{ __('common.info.date_of_birth.placeholder') }}
                                </label>
                                @error('date_of_birth')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-20">
                            <label class="label fs-16 mb-2">
                                {{ __('common.info.email.title') }} <span class="text-danger">*</span>
                            </label>
                            <div class="form-floating">
                                <input class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email', $user->email) }}"
                                    placeholder="{{ __('common.info.email.placeholder') }}" type="email" />
                                <label>
                                    {{ __('common.info.email.placeholder') }}
                                </label>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-20">
                            <label class="label fs-16 mb-2">
                                {{ __('common.info.phone.title') }}
                            </label>
                            <div class="form-floating">
                                <input class="form-control @error('phone') is-invalid @enderror" name="phone"
                                    value="{{ old('phone', $user->phone) }}"
                                    placeholder="{{ __('common.info.phone.placeholder') }}" type="text" />
                                <label>
                                    {{ __('common.info.phone.placeholder') }}
                                </label>
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-20">
                            <label class="label fs-16 mb-2">
                                {{ __('common.info.address.title') }}
                            </label>
                            <div class="form-floating">
                                <input class="form-control @error('address') is-invalid @enderror" name="address"
                                    value="{{ old('address', $user->address) }}"
                                    placeholder="{{ __('common.info.address.placeholder') }}" type="text" />
                                <label>
                                    {{ __('common.info.address.placeholder') }}
                                </label>
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                <h3 class="mb-20">
                    {{ __('common.section.settings') }}
                </h3>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-20">
                            <label class="label fs-16 mb-2">
                                {{ __('common.info.status.title') }} <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-control @error('status') is-invalid @enderror"
                                name="status">
                                <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>
                                    {{ __('admin/pages/users/table.values.status.active') }}
                                </option>
                                <option value="pending" {{ $user->status == 'pending' ? 'selected' : '' }}>
                                    {{ __('admin/pages/users/table.values.status.pending') }}
                                </option>
                                <option value="banned" {{ $user->status == 'banned' ? 'selected' : '' }}>
                                    {{ __('admin/pages/users/table.values.status.banned') }}
                                </option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-20">
                            <label class="label fs-16 mb-2">
                                {{ __('common.info.role.title') }} <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-control @error('role_id') is-invalid @enderror"
                                name="role_id">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                        {{ __('common.info.role.' . strtolower($role->name)) ?? $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="d-flex gap-2 justify-content-center">
                            <button class="btn btn-primary fw-normal text-white" type="submit" id="submitBtn"
                                data-processing-text="{{ __('common.processing') }}">
                                <span id="btnText">{{ __('common.button.update') }}</span>
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-danger fw-normal text-white">
                                {{ __('common.button.cancel') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>