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
        <li class="nav-title">Retail Module</li>
        <li class="nav-item"><a class="nav-link" href="{{ route('retail.index') }}">
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
                @foreach($categories as $category)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('surveys.create', ['category' => $category->id]) }}">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach
                <li class="nav-item"><a class="nav-link" href="{{ route('surveys.index') }}"> History</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('surveys.continue') }}"> Incomplete Surveys</a></li>
            </ul>
        </li>
        @can('Manage Checklists')
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-puzzle') }}"></use>
                </svg> Checklist
            </a>
            <ul class="nav-group-items">
                <li class="nav-item"><a class="nav-link" href="{{ route('categories.index') }}"><span class="nav-icon"></span> Categories </a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('checklists.create') }}"><span class="nav-icon"></span> New Checklist</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('checklists.index') }}"><span class="nav-icon"></span> Checklist</a></li>
            </ul>
        </li>
        @endcan    
        <li class="nav-divider"></li>  
        @can('Setup Module')
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-building') }}"></use>
                </svg> Setup
            </a>
            <ul class="nav-group-items">  
                <li class="nav-item"><a class="nav-link" href="{{ route('territory_managers.index') }}"><span class="nav-icon"></span> TM's</a></li>          
                <li class="nav-item"><a class="nav-link" href="{{ route('dealers.index') }}"><span class="nav-icon"></span> Dealers</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('station_managers.index') }}"><span class="nav-icon"></span> Station Managers</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('stations.index') }}"><span class="nav-icon"></span>Service Stations</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('locations.index') }}"><span class="nav-icon"></span>Other Locations</a></li>
            </ul>
        </li>
        @endcan    
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>