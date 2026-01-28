@props(['user'])

@if($user->status === 'pending')
    @flasher_render

    <button id="resend-activation-btn" 
            class="btn btn-warning text-white fw-normal fs-16 hover-bg" 
            style="padding: 12px 15px;"
            data-user-id="{{ $user->id }}"
            data-route="{{ route('resend-activation') }}"
            data-csrf="{{ csrf_token() }}">
        <i class="ri-error-warning-line"></i> <span id="resend-text">Activate your account</span>
        <span id="btnLoading" class="spinner-border spinner-border-sm ml-2 d-none"></span>
    </button>

    <script src="{{ asset('assets/client/js/custom/resend-activation.js') }}"></script>
@endif
