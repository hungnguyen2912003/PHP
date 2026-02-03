<div class="d-flex align-items-center text-nowrap">
    <div class="flex-shrink-0">
        <img alt="avatar" class="rounded-circle" src="{{ $user->avatar_url ? asset($user->avatar_url) : asset('assets/images/user.png') }}" style="width: 35px; height: 35px;"/>
    </div>
    <div class="flex-grow-1 ms-12 position-relative top-2">
        <h3 class="fw-medium mb-0 fs-16">
            {{ $user->fullname }}
        </h3>
    </div>
</div>