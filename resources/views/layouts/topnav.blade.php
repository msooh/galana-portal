
<header class="header header-sticky mb-4">
    <div class="container-fluid">
        <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <svg class="icon icon-lg">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-menu') }}"></use>
            </svg>
        </button>
        <a class="header-brand d-md-none" href="#">            
            <img src="{{ asset('assets/img/New logo-01.png') }}" width="70" height=auto alt="Galana Logo">
        </a>
        <ul class="header-nav d-none d-md-flex">
            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Dashboard</a></li>
        </ul>
        <ul class="header-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="#">
                <svg class="icon icon-lg">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-bell') }}"></use>
                </svg>
            </a></li>
            <li class="nav-item"><a class="nav-link" href="#">
                <svg class="icon icon-lg">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-list-rich') }}"></use>
                </svg>
            </a></li>
            <li class="nav-item"><a class="nav-link" href="#">
                <svg class="icon icon-lg">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-envelope-open') }}"></use>
                </svg>
            </a></li>
        </ul>
        <ul class="header-nav ms-3">
            <li class="nav-item dropdown">
                <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-md">
                        <img class="avatar-img" src="{{ asset('assets/img/avatars/default.jpg') }}" alt="user@email.com">
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-light py-2">
                        <div class="fw-semibold">Account</div>
                    </div>
                    <!--<a class="dropdown-item" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-bell') }}"></use>
                        </svg> Notifications<span class="badge badge-sm bg-info ms-2">42</span>
                    </a>
                    <a class="dropdown-item" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-envelope-open') }}"></use>
                        </svg> Emails<span class="badge badge-sm bg-success ms-2">42</span>
                    </a>-->
                    <a class="dropdown-item" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-task') }}"></use>
                        </svg> Visits<span class="badge badge-sm bg-danger ms-2">42</span>
                    </a>
                    <div class="dropdown-header bg-light py-2">
                        <div class="fw-semibold">Settings</div>
                    </div>
                    <a class="dropdown-item" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-user') }}"></use>
                        </svg> Profile
                    </a>
                    @can('manage_users')
                    <a class="dropdown-item" href="{{ route('users.index') }}">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-user') }}"></use>
                        </svg> Users
                    </a>
                    @endcan
                    <!--<a class="dropdown-item" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-settings') }}"></use>
                        </svg> Settings
                    </a>-->
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-account-logout') }}"></use>
                        </svg> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>                   
                </div>
            </li>
        </ul>
    </div>
    <div class="header-divider"></div>
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
                <li class="breadcrumb-item">
                    <!-- if breadcrumb is single--><span>Home</span>
                </li>
                <li class="breadcrumb-item active"><span>Dashboard</span></li>
            </ol>
        </nav>
    </div>
</header>