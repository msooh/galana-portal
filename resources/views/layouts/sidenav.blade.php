<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <img class="sidebar-brand-full" width="150" height="auto" src="{{ asset('assets/img/Logos/horizontal_logo_logo_full_white.png') }}" alt="Galana Logo">
        <svg class="sidebar-brand-narrow" width="46" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('assets/brand/coreui.svg#signet') }}"></use>
        </svg>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-title">Retail Quality Checklist</li>
        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}"></use>
            </svg> Dashboard</a></li>
        <li class="nav-title"></li>
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-notes') }}"></use>
                </svg> Surveys
            </a>
            <ul class="nav-group-items">
                <li class="nav-item"><a class="nav-link" href="{{ route('surveys.create') }}"> New Survey</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('surveys.index') }}"> History</a></li>
            </ul>
        </li>
        @can('manage_safeties')
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-shield-alt') }}"></use>
                </svg> HSSEQ
            </a>
            <ul class="nav-group-items">
                <li class="nav-item"><a class="nav-link" href="{{ route('hsseq.create') }}"> New Incident Report</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('hsseq.create') }}"> History</a></li>
            </ul>
        </li>
        @endcan
        
        @can('manage_dealers')
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-user-plus') }}"></use>
                </svg> Dealers
            </a>
            <ul class="nav-group-items">
                <li class="nav-item"><a class="nav-link" href="{{ route('dealers.create') }}"><span class="nav-icon"></span> New Dealer</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('dealers.index') }}"><span class="nav-icon"></span> Dealers</a></li>
            </ul>
        </li>
        @endcan

        @can('manage_station_managers')
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-user-plus') }}"></use>
                </svg> Station Managers
            </a>
            <ul class="nav-group-items">
                <li class="nav-item"><a class="nav-link" href="{{ route('station_managers.create') }}"><span class="nav-icon"></span> New Station Manager</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('station_managers.index') }}"><span class="nav-icon"></span> Station Managers</a></li>
            </ul>
        </li>
        @endcan

        @can('manage_stations')
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-building') }}"></use>
                </svg> Stations
            </a>
            <ul class="nav-group-items">
                <li class="nav-item"><a class="nav-link" href="{{ route('stations.create') }}"><span class="nav-icon"></span> New Station</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('stations.index') }}"><span class="nav-icon"></span> Stations List</a></li>
            </ul>
        </li>
        @endcan

        @can('manage_checklists')
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-puzzle') }}"></use>
                </svg> Checklist
            </a>
            <ul class="nav-group-items">
                <li class="nav-item"><a class="nav-link" href="{{ route('checklists.create') }}"><span class="nav-icon"></span> New Checklist</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('checklists.index') }}"><span class="nav-icon"></span> Checklist</a></li>
            </ul>
        </li>
        @endcan    
        <li class="nav-title">Tasks</li>
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-shield-alt') }}"></use>
                </svg> Assigned Tasks
            </a>
            <ul class="nav-group-items">
                <li class="nav-item"><a class="nav-link" href="{{ route('safeties.pending') }}"> Pending</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('safeties.closedTasks') }}"> Completed</a></li>
            </ul>
        </li>
        <li class="nav-divider"></li>
        @can('manage_users')
        <li class="nav-title">USERS</li>
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-star') }}"></use>
                </svg> Manage
            </a>
            <ul class="nav-group-items">
                <li class="nav-item"><a class="nav-link" href="{{ route('users.create') }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-account-logout') }}"></use>
                    </svg> Add User</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-account-logout') }}"></use>
                    </svg> List</a></li>
                <li class="nav-item"><a class="nav-link" href="404.html" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-bug') }}"></use>
                    </svg> Logs</a></li>
            </ul>
        </li>
        @endcan
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>