@extends('layouts.main')

@section('content')
<div class="container-lg">
    <!-- Cards for Territory Managers, Stations, Dealers, Surveys -->
    <div class="row">
        <!-- Territory Managers Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card mb-4">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold"> <span class="fs-6 fw-normal">({{ number_format($dashboardData['tmPercentageChange'], 2) }}%
                                @if ($dashboardData['tmPercentageChange'] > 0)
                                <svg class="icon">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-top"></use>
                                </svg>
                                @else
                                <svg class="icon">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-bottom"></use>
                                </svg>
                                @endif
                                )</span></div>
                        <div>Territory Managers</div>
                    </div>
                    <!-- Dropdown button -->
                    <div class="dropdown">
                        <button class="btn btn-transparent  p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                            </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div>
                    </div>
                </div>
                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                    <canvas class="chart" id="card-chart1" height="70"></canvas>
                </div>
            </div>
        </div>
        <!-- /.col-->

        <!-- Stations Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card mb-4">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">{{ $dashboardData['stationsCount'] }} <span class="fs-6 fw-normal">({{ number_format($dashboardData['newStationsPercentage'], 2) }}%
                                @if ($dashboardData['newStationsPercentage'] > 0)
                                <svg class="icon">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-top"></use>
                                </svg>
                                @else
                                <svg class="icon">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-bottom"></use>
                                </svg>
                                @endif
                                )</span></div>
                        <div>Stations</div>
                    </div>
                    <!-- Dropdown button -->
                    <div class="dropdown">
                        <button class="btn btn-transparent text-white p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                            </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div>
                    </div>
                </div>
                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                    <canvas class="chart" id="card-chart2" height="70"></canvas>
                </div>
            </div>
        </div>
        <!-- /.col-->

        <!-- Dealers Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card mb-4">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">{{ $dashboardData['dealersCount'] }} <span class="fs-6 fw-normal">({{ number_format($dashboardData['dealersPercentage'], 2) }}%
                                @if ($dashboardData['dealersPercentage'] > 0)
                                <svg class="icon">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-top"></use>
                                </svg>
                                @else
                                <svg class="icon">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-bottom"></use>
                                </svg>
                                @endif
                                )</span></div>
                        <div>Dealers</div>
                    </div>
                    <!-- Dropdown button -->
                    <div class="dropdown">
                        <button class="btn btn-transparent  p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                            </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div>
                    </div>
                </div>
                <div class="c-chart-wrapper mt-3" style="height:70px;">
                    <canvas class="chart" id="card-chart3" height="70"></canvas>
                </div>
            </div>
        </div>
        <!-- /.col-->

        <!-- Surveys Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card mb-4 ">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">{{ $dashboardData['surveyCount'] }} <span class="fs-6 fw-normal">({{ number_format($dashboardData['visitsPercentage'], 2) }}%
                                @if ($dashboardData['visitsPercentage'] > 0)
                                <svg class="icon">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-top"></use>
                                </svg>
                                @else
                                <svg class="icon">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-bottom"></use>
                                </svg>
                                @endif
                                )</span></div>
                        <div>Surveys</div>
                    </div>
                    <!-- Dropdown button -->
                    <div class="dropdown">
                        <button class="btn btn-transparent  p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                            </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div>
                    </div>
                </div>
                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                    <canvas class="chart" id="card-chart4" height="70"></canvas>
                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>
    <!-- /.row-->

    <!-- Other statistics -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title mb-0">Surveys</h4>
                    <div class="small text-medium-emphasis">January - July 2022</div>
                </div>
                <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
                    <div class="btn-group btn-group-toggle mx-3" data-coreui-toggle="buttons">
                        <input class="btn-check" id="option1" type="radio" name="options" autocomplete="off">
                        <label class="btn btn-outline-secondary"> Day</label>
                        <input class="btn-check" id="option2" type="radio" name="options" autocomplete="off" checked="">
                        <label class="btn btn-outline-secondary active"> Month</label>
                        <input class="btn-check" id="option3" type="radio" name="options" autocomplete="off">
                        <label class="btn btn-outline-secondary"> Year</label>
                    </div>
                    <button class="btn btn-primary" type="button">
                        <svg class="icon">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-cloud-download"></use>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="c-chart-wrapper" style="height:300px;margin-top:40px;">
                <canvas class="chart" id="main-chart" height="300"></canvas>
            </div>
        </div>
        <div class="card-footer">
            <div class="row row-cols-1 row-cols-md-5 text-center">
                <!-- Visits -->
                <div class="col mb-sm-2 mb-0">
                    <div class="text-medium-emphasis">Visits</div>
                    <div class="fw-semibold">{{ $dashboardData['visits'] }} Visits ({{ number_format($dashboardData['visitsPercentage'], 2) }}%)</div>
                    <div class="progress progress-thin mt-2">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $dashboardData['visitsPercentage'] }}%" aria-valuenow="{{ $dashboardData['visitsPercentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <!-- New Stations -->
                <div class="col mb-sm-2 mb-0">
                    <div class="text-medium-emphasis">New Stations</div>
                    <div class="fw-semibold">{{ $dashboardData['newStations'] }} Stations ({{ number_format($dashboardData['newStationsPercentage'], 2) }}%)</div>
                    <div class="progress progress-thin mt-2">
                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $dashboardData['newStationsPercentage'] }}%" aria-valuenow="{{ $dashboardData['newStationsPercentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <!-- Dealers -->
                <div class="col mb-sm-2 mb-0">
                    <div class="text-medium-emphasis">Dealers</div>
                    <div class="fw-semibold">{{ $dashboardData['dealers'] }} Dealers ({{ number_format($dashboardData['dealersPercentage'], 2) }}%)</div>
                    <div class="progress progress-thin mt-2">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $dashboardData['dealersPercentage'] }}%" aria-valuenow="{{ $dashboardData['dealersPercentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <!-- New Users -->
                <div class="col mb-sm-2 mb-0">
                    <div class="text-medium-emphasis">New Users</div>
                    <div class="fw-semibold">{{ $dashboardData['newUsers'] }} Users ({{ number_format($dashboardData['newUsersPercentage'], 2) }}%)</div>
                    <div class="progress progress-thin mt-2">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $dashboardData['newUsersPercentage'] }}%" aria-valuenow="{{ $dashboardData['newUsersPercentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <!-- Visit Rate -->
                <div class="col mb-sm-2 mb-0">
                    <div class="text-medium-emphasis">Visit Rate</div>
                    <div class="fw-semibold">{{ number_format($dashboardData['visitRatePercentage'], 2) }}%</div>
                    <div class="progress progress-thin mt-2">
                        <div class="progress-bar" role="progressbar" style="width: {{ $dashboardData['visitRatePercentage'] }}%" aria-valuenow="{{ $dashboardData['visitRatePercentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card.mb-4-->
    <script src="{{ asset('vendors/chart.js/js/chart.min.js') }}"></script>
    <script src="{{ asset('vendors/@coreui/chartjs/js/coreui-chartjs.js') }}"></script>
@endsection
