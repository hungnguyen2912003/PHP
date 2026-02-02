<form id="addUserForm" action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                <h3 class="mb-20">
                    {{ __('common.section.profile_information') }}
                </h3>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-20">
                            <label class="label fs-16 mb-2">{{ __('common.info.full_name.title') }}</label>
                            <div class="form-floating">
                                <input class="form-control" id="fullname" name="fullname"
                                    placeholder="{{ __('common.info.full_name.placeholder') }}" type="text"
                                    value="{{ old('fullname') }}" />
                                <label for="fullname"><i
                                        class="ri-user-line"></i>{{ __('common.info.full_name.placeholder') }}</label>
                            </div>
                            @error('fullname')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-20">
                            <label class="label fs-16 mb-2">{{ __('common.info.email.title') }}</label>
                            <div class="form-floating">
                                <input class="form-control" id="email" name="email"
                                    placeholder="{{ __('common.info.email.placeholder') }}" type="email"
                                    value="{{ old('email') }}" />
                                <label for="email"><i
                                        class="ri-mail-line"></i>{{ __('common.info.email.placeholder') }}</label>
                            </div>
                            @error('email')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-20">
                            <label class="label fs-16 mb-2">{{ __('common.info.role.title') }}</label>
                            <div class="form-floating">
                                <select class="form-select form-control" id="role_id" name="role_id">
                                    <option value="">{{ __('common.info.role.select') }}</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                            {{ __('common.info.role.' . strtolower($role->name)) }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="role_id">{{ __('common.info.role.select') }}</label>
                            </div>
                            @error('role_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="d-flex gap-2 justify-content-center">
                            <button class="btn btn-primary fw-normal text-white" type="submit" id="submitBtn"
                                data-processing-text="{{ __('common.processing') }}">
                                <span id="btnText">{{ __('common.button.add') }}</span>
                                <span id="btnLoading" class="spinner-border spinner-border-sm ml-2 d-none"></span>
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