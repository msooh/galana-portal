<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <img class="sidebar-brand-full" width="150" height="auto" src="{{ asset('assets/img/Logos/horizontal_logo_logo_full_white.png') }}" alt="Galana Logo">
        <svg class="sidebar-brand-narrow" width="46" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('assets/brand/coreui.svg#signet') }}"></use>
        </svg>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        
        <li class="nav-item">
            <a class="btn btn-light shadow p-3 mb-4 mt-5 rounded" href="{{ route('home') }}" style="display: flex; align-items: center; margin-left:10px; margin-right:10px;">
                <svg class="nav-icon text-dark" style="margin-right: 5px; ">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-arrow-circle-top') }}"></use>
                   
                </svg>
                Go To Modules
            </a>
        </li>       
        <li class="nav-title">Training Module</li>
        <li class="nav-item"><a class="nav-link" href="{{ route('training.dashboard') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}"></use>
            </svg> Dashboard</a></li>
        <li class="nav-title"></li>
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-notes') }}"></use>
                </svg> Trainings
            </a>
            <ul class="nav-group-items">
                @can('Create Training')
                    <li class="nav-item"><a class="nav-link" href="{{ route('training.create') }}"> New Entry</a></li>
                @endcan  
                <li class="nav-item"><a class="nav-link" href="{{ route('training.index') }}"> History</a></li>
            </ul>
        </li>    
        <li class="nav-divider"></li>  
           
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>