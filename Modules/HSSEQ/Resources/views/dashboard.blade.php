@extends('hsseq::layouts.master')

@section('content')
<div class="container-lg">
    <!-- Cards for Safety Reports, Tasks -->
    <div class="row">
        <!-- Total Safety Reports Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card mb-4">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">{{ $totalReports }} <span class="fs-6 fw-normal">{{ number_format($totalReports / $totalReports * 100, 2) }}%
                            <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-top"></use>
                            </svg>
                        </span></div>
                        <div>Total Safety Reports</div>
                    </div>
                    <!-- Dropdown button -->
                    <div class="dropdown">
                        <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

        <!-- Un-Assigned or Pending Tasks Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card mb-4">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">{{ $pendingTasks }} <span class="fs-6 fw-normal">{{ number_format($pendingTasks / $totalReports * 100, 2) }}%
                            <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-top"></use>
                            </svg>
                        </span></div>
                        <div>Un-Assigned Tasks</div>
                    </div>
                    <!-- Dropdown button -->
                    <div class="dropdown">
                        <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

        <!-- Completed Tasks Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card mb-4">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">{{ $completedTasks }} <span class="fs-6 fw-normal">{{ number_format($completedTasks / $totalReports * 100, 2) }}%
                            <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-top"></use>
                            </svg>
                        </span></div>
                        <div>Completed Tasks</div>
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

        <!-- In Progress Reports Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card mb-4">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">{{ $inProgressTasks }} <span class="fs-6 fw-normal">{{ number_format($inProgressTasks / $totalReports * 100, 2) }}%
                            <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-top"></use>
                            </svg>
                        </span></div>
                        <div>In Progress</div>
                    </div>
                    <!-- Dropdown button -->
                    <div class="dropdown">
                        <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                    <h4 class="card-title mb-0">Safety Reports</h4>
                    <div class="small text-medium-emphasis">January - December {{ date('Y') }}</div>
                </div>
                <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
                    <div class="btn-group btn-group-toggle mx-3" data-coreui-toggle="buttons">
                        <input class="btn-check" id="dayOption" type="radio" name="options" autocomplete="off">
                        <label class="btn btn-outline-secondary" for="dayOption">Day</label>
                        <input class="btn-check" id="monthOption" type="radio" name="options" autocomplete="off" checked="">
                        <label class="btn btn-outline-secondary " for="monthOption">Month</label>
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
          
            <div class="c-chart-wrapper mt-3 mx-3" style="height:250px;">
                <canvas class="chart" id="safetyReportChart" ></canvas>
            </div>
        </div>
        <div class="card-footer">
            <div class="row row-cols-1 row-cols-md-5 text-center">
                <!-- Total Reports -->
                <div class="col mb-sm-2 mb-0">
                    <div class="text-medium-emphasis">Total Reports</div>
                    <div class="fw-semibold">{{ $totalReports }} Reports (100%)</div>
                    <div class="progress progress-thin mt-2">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <!-- High Risk -->
                <div class="col mb-sm-2 mb-0">
                    <div class="text-medium-emphasis">High Risk</div>
                    <div class="fw-semibold">{{ $highRiskReports }} High Risk ({{ number_format($highRiskPercentage, 2) }}%)</div>
                    <div class="progress progress-thin mt-2">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $highRiskPercentage }}%" aria-valuenow="{{ $highRiskPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <!-- Medium Risks -->
                <div class="col mb-sm-2 mb-0">
                    <div class="text-medium-emphasis">Medium Risk</div>
                    <div class="fw-semibold">{{ $mediumRiskReports }} Medium Risk ({{ number_format($mediumRiskPercentage, 2) }}%)</div>
                    <div class="progress progress-thin mt-2">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $mediumRiskPercentage }}%" aria-valuenow="{{ $mediumRiskPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <!-- Pending -->
                <div class="col mb-sm-2 mb-0">
                    <div class="text-medium-emphasis">Low Risk Reports</div>
                    <div class="fw-semibold">{{ $lowRiskReports }} Low Risk ({{ number_format($lowRiskPercentage, 2) }}%)</div>
                    <div class="progress progress-thin mt-2">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $lowRiskPercentage }}%" aria-valuenow="{{ $lowRiskPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                
                <!-- Others -->
                <div class="col mb-sm-2 mb-0">
                    <div class="text-medium-emphasis">Pending Tasks</div>
                    <div class="fw-semibold">{{ $pendingTasks }} Pending ({{ number_format($pendingPercentage, 2) }}%)</div>
                    <div class="progress progress-thin mt-2">
                        <div class="progress-bar bg-muted" role="progressbar" style="width: {{ $pendingPercentage }}%" aria-valuenow="{{ $pendingPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-->
</div>
<!-- /.container-fluid-->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Data from the controller
        const dailyReports = @json($dailyReports);
        const monthlyReports = @json($monthlyReports);
        const yearlyReports = @json($yearlyReports);
    
        const ctx = document.getElementById('safetyReportChart').getContext('2d');
    
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: Object.keys(monthlyReports),
                datasets: [{
                    label: 'Safety Reports',
                    data: Object.values(monthlyReports),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
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
            chart.data.labels = Object.keys(dailyReports);
            chart.data.datasets[0].data = Object.values(dailyReports);
            chart.update();
        });
    
        document.getElementById('monthOption').addEventListener('click', function () {
            chart.data.labels = Object.keys(monthlyReports);
            chart.data.datasets[0].data = Object.values(monthlyReports);
            chart.update();
        });
    
        document.getElementById('yearOption').addEventListener('click', function () {
            chart.data.labels = Object.keys(yearlyReports);
            chart.data.datasets[0].data = Object.values(yearlyReports);
            chart.update();
        });

        // Download button event listener
        document.getElementById('downloadButton').addEventListener('click', function () {
            window.print();
        });
    });
</script>
@endsection
