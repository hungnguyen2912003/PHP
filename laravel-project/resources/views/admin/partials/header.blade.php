<div class="header-left">
    <a href="index.html" class="logo">
        <img src="{{ asset('assets/admin/main/img/logo.png') }}" alt="Logo">
    </a>
    <a href="index.html" class="logo logo-small">
        <img src="{{ asset('assets/admin/main/img/logo-small.png') }}" alt="Logo" width="30" height="30">
    </a>
</div>
<div class="menu-toggle">
    <a href="javascript:void(0);" id="toggle_btn">
        <i class="fas fa-bars"></i>
    </a>
</div>

<div class="top-nav-search">
    <form>
        <input type="text" class="form-control" placeholder="Search here">
        <button class="btn" type="submit"><i class="fas fa-search"></i></button>
    </form>
</div>
<a class="mobile_btn" id="mobile_btn">
    <i class="fas fa-bars"></i>
</a>

<ul class="nav user-menu">
    <li class="nav-item zoom-screen me-2">
        <a href="#" class="nav-link header-nav-list win-maximize">
            <img src="{{ asset('assets/admin/main/img/icons/header-icon-04.svg') }}" alt="">
        </a>
    </li>

    <li class="nav-item dropdown has-arrow new-user-menus">
        <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
            <span class="user-img">
                <img class="rounded-circle" src="{{ asset('assets/admin/main/img/profiles/avatar-01.jpg') }}"
                    width="31" alt="{{ auth('api')->user()->name }}">
                <div class="user-text">
                    <h6>{{ auth('api')->user()->name }}</h6>
                    <p class="text-muted mb-0">{{ auth('api')->user()->role === 'admin' ? 'Administrator' : auth('api')->user()->role }}</p>
                </div>
            </span>
        </a>
        <div class="dropdown-menu">
            <div class="user-header">
                <div class="avatar avatar-sm">
                    <img src="{{ asset('assets/admin/main/img/profiles/avatar-01.jpg') }}" alt="User Image"
                        class="avatar-img rounded-circle">
                </div>
                <div class="user-text">
                    <h6>{{ auth('api')->user()->name }}</h6>
                    <p class="text-muted mb-0">{{ auth('api')->user()->role === 'admin' ? 'Administrator' : auth('api')->user()->role }}</p>
                </div>
            </div>
            <a class="dropdown-item" href="profile.html">My Profile</a>
            <a class="dropdown-item" href="inbox.html">Inbox</a>
            <a class="dropdown-item" href="#" id="logout-link">Logout</a>
        </div>
    </li>

</ul>

<script>
    document.getElementById('logout-link').addEventListener('click', async function(e) {
        e.preventDefault();
        
        try {
            const response = await fetch('{{ url("/api/admin/logout") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                credentials: 'same-origin'
            });

            if (response.ok) {
                window.location.href = "{{ route('admin.login') }}";
            } else {
                alert('Logout failed');
            }
        } catch (error) {
            console.error('Logout error:', error);
        }
    });
</script>