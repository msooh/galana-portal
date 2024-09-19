@extends('retail::layouts.master')

@section('content')
<div class="container-lg">
    <!-- Cards for Territory Managers, Stations, Dealers, Surveys -->
    <div class="row">
        <!-- Territory Managers Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card mb-4">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold"> {{$dashboardData['territoryManagersCount']}}<span class="fs-6 fw-normal">({{ number_format($dashboardData['tmPercentageChange'], 2) }}%
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
                        <div>Total TM's</div>
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
                        <div>Total Stations</div>
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
                        <div>Total Dealers</div>
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
                        <div>Total Surveys</div>
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
                    <h4 class="card-title mb-0">Total Surveys</h4>
                    <div class="small text-medium-emphasis">January - December</div>
                </div>
                <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
                    <div class="btn-group btn-group-toggle mx-3" data-coreui-toggle="buttons">
                        <input class="btn-check" id="dayOption" type="radio" name="options" autocomplete="off">
                        <label class="btn btn-outline-secondary" for="dayOption">Day</label>
                        <input class="btn-check" id="monthOption" type="radio" name="options" autocomplete="off" checked="">
                        <label class="btn btn-outline-secondary" for="monthOption">Month</label>
                        <input class="btn-check" id="yearOption" type="radio" name="options" autocomplete="off">
                        <label class="btn btn-outline-secondary" for="yearOption">Year</label>
                    </div>
                    <button class="btn btn-primary" type="button" id="downloadButton">
                        <svg class="icon">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-cloud-download"></use>
                        </svg>
                    </button>
                </div>
            </div>
            <!--<div class="c-chart-wrapper" style="height:300px;margin-top:40px;">
                <canvas class="chart" id="surveyReportChart" height="300"></canvas>
            </div>-->
            <div class="c-chart-wrapper mt-3 mx-3" style="height:250px;">
                <canvas class="chart" id="surveyReportChart"></canvas>
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
    <!--Survey Count By User -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="justify-content-between">
                <div>
                    <h4 class="card-title mb-0">Surveys by User</h4>
                    <div class="c-chart-wrapper mt-3 mx-3" style="height:300px;">
                        <canvas class="chart" id="surveyUserChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- /.card.mb-4-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        // Data from the controller
        const dashboardData = @json($dashboardData);
        const dailySurveyReports = @json($dailySurveyReports);
        const monthlySurveyReports = @json($monthlySurveyReports);
        const yearlySurveyReports = @json($yearlySurveyReports);
        const surveyUserData = @json($surveyUserData);
       
        const ctx = document.getElementById('surveyReportChart').getContext('2d');

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: Object.keys(monthlySurveyReports), 
                datasets: [{
                    label: 'Survey Reports',
                    data: Object.values(monthlySurveyReports),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Event listeners for buttons
        document.getElementById('dayOption').addEventListener('click', function () {
            chart.data.labels = Object.keys(dailySurveyReports);
            chart.data.datasets[0].data = Object.values(dailySurveyReports);
            chart.update();
        });

        document.getElementById('monthOption').addEventListener('click', function () {
            chart.data.labels = Object.keys(monthlySurveyReports);
            chart.data.datasets[0].data = Object.values(monthlySurveyReports);
            chart.update();
        });

        document.getElementById('yearOption').addEventListener('click', function () {
            chart.data.labels = Object.keys(yearlySurveyReports);
            chart.data.datasets[0].data = Object.values(yearlySurveyReports);
            chart.update();
        });

        // Download button event listener
        document.getElementById('downloadButton').addEventListener('click', function () {
            window.print();
        });
        const ctxSurveyUser = document.getElementById('surveyUserChart').getContext('2d');

        const surveyUserChart = new Chart(ctxSurveyUser, {
            type: 'bar', 
            data: {
                labels: surveyUserData.labels, 
                datasets: [{
                    label: 'Surveys by User',
                    data: surveyUserData.data,
                    backgroundColor: '#007bff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Users'
                        },
                        ticks: {
                            autoSkip: false 
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });


        // Chart data for other charts
        const chartsData = {
            cardChart1: {
                labels: ['TM Count'],
                datasets: [{
                    label: 'Territory Managers',
                    data: [dashboardData.territoryManagersCount],
                    backgroundColor: '#007bff',
                }]
            },
            cardChart2: {
                labels: ['Total Stations'],
                datasets: [{
                    label: 'Stations',
                    data: [dashboardData.stationsCount],
                    backgroundColor: '#28a745',
                }]
            },
            cardChart3: {
                labels: ['Total Dealers'],
                datasets: [{
                    label: 'Dealers',
                    data: [dashboardData.dealersCount],
                    backgroundColor: '#ffc107',
                }]
            },
            cardChart4: {
                labels: ['Total Surveys'],
                datasets: [{
                    label: 'Surveys',
                    data: [dashboardData.surveyCount],
                    backgroundColor: '#dc3545',
                }]
            },
           
        };

        // Initialize charts
        const ctx1 = document.getElementById('card-chart1').getContext('2d');
        const ctx2 = document.getElementById('card-chart2').getContext('2d');
        const ctx3 = document.getElementById('card-chart3').getContext('2d');
        const ctx4 = document.getElementById('card-chart4').getContext('2d');
        const ctx5 = document.getElementById('surveyReportChart').getContext('2d');
        const ctx6 = document.getElementById('surveyUserChart').getContext('2d');

        new Chart(ctx1, {
            type: 'bar',
            data: chartsData.cardChart1,
            options: { responsive: true }
        });

        new Chart(ctx2, {
            type: 'bar',
            data: chartsData.cardChart2,
            options: { responsive: true }
        });

        new Chart(ctx3, {
            type: 'bar',
            data: chartsData.cardChart3,
            options: { responsive: true }
        });

        new Chart(ctx4, {
            type: 'bar',
            data: chartsData.cardChart4,
            options: { responsive: true }
        });

        new Chart(ctx6, {
            type: 'bar',
            data: chartsData.surveyUserChart,
            options: { responsive: true }
        });
    });

    </script>
        

@endsection
