@extends('suggestion::layouts.master')

@section('content')
<div class="container-lg">
    <!-- Cards for Suggestions Module -->
    <div class="row">
        <!-- Safety Reports Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card mb-4">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">{{ $totalSuggestions }} 
                            <span class="fs-6 fw-normal">{{ $thisMonthPercentage }}%
                                <svg class="icon">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-bottom"></use>
                                </svg>    
                            </span>
                        </div>
                        <div>Total Suggestions</div>
                    </div>                    
                </div>
                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                    <canvas class="chart" id="card-chart1" height="70"></canvas>
                </div>
            </div>
        </div>
        <!-- /.col-->

        <!-- This Month Suggestions Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card mb-4">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">{{ $thisMonthSuggestions }} 
                            <span class="fs-6 fw-normal">{{ $thisMonthPercentage }}%
                                <svg class="icon">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-bottom"></use>
                                </svg>
                            </span>
                        </div>
                        <div>This Month</div>
                    </div>                    
                </div>
                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                    <canvas class="chart" id="card-chart2" height="70"></canvas>
                </div>
            </div>
        </div>
        <!-- /.col-->

        <!-- Last Month Suggestions Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card mb-4">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">{{ $lastMonthSuggestions }}
                            <span class="fs-6 fw-normal">{{ $lastMonthPercentage }}%
                                <svg class="icon">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-top"></use>
                                </svg>
                            </span>
                        </div>
                        <div>Last Month</div>
                    </div>                    
                </div>
                <div class="c-chart-wrapper mt-3" style="height:70px;">
                    <canvas class="chart" id="card-chart3" height="70"></canvas>
                </div>
            </div>
        </div>
        <!-- /.col-->

        <!-- High Risk Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card mb-4 ">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">1 <span class="fs-6 fw-normal">100%
                                
                                <svg class="icon">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-bottom"></use>
                                </svg>
                              </span></div>
                        <div>Total Boxes</div>
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
    <div class="col-12 dashboard">
        <!-- Recent Activity -->
        <div class="card mb-4">
            <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                    </li>
                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                </ul>
            </div>

            <div class="card-body">
                <h5 class="card-title">Recent Suggestions <span>| Timeline</span></h5>

                <div class="activity">
                    @foreach($suggestions as $suggestion)
                    <div class="activity-item d-flex">
                        <div class="activite-label">{{ $suggestion->created_at->diffForHumans() }}</div>
                        <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                        <div class="activity-content">
                            {{ $suggestion->suggestion ?? '--' }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div><!-- End Recent Activity -->
    </div>
    <!-- Other statistics -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title mb-0">Suggestions</h4>
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
                        <i class="fa fa-cloud-download"></i>
                    </button>                    
                </div>
            </div>        
            <div class="c-chart-wrapper mt-3 mx-3" style="height:250px;">
                <canvas class="chart" id="suggestionsChart" ></canvas>
            </div>
        </div>        
        <div class="card-footer">
            <div class="row row-cols-1 row-cols-md-5 text-center">
                <!-- Total Suggestions -->
                <div class="col mb-sm-2 mb-0">
                    <div class="text-medium-emphasis">Total Suggestions</div>
                    <div class="fw-semibold">{{ $totalSuggestions }} Reports ({{ number_format($totalSuggestions > 0 ? 100 : 0, 2) }}%)</div>
                    <div class="progress progress-thin mt-2">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ number_format($totalSuggestions > 0 ? 100 : 0, 2) }}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>        
                <!-- This Month Suggestions -->
                <div class="col mb-sm-2 mb-0">
                    <div class="text-medium-emphasis">This Month</div>
                    <div class="fw-semibold">{{ $thisMonthSuggestions }} Suggestions ({{ number_format($thisMonthPercentage, 2) }}%)</div>
                    <div class="progress progress-thin mt-2">
                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ number_format($thisMonthPercentage, 2) }}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>        
                <!-- Last Month Suggestions -->
                <div class="col mb-sm-2 mb-0">
                    <div class="text-medium-emphasis">Last Month</div>
                    <div class="fw-semibold">{{ $lastMonthSuggestions }} Suggestions ({{ number_format($lastMonthPercentage, 2) }}%)</div>
                    <div class="progress progress-thin mt-2">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ number_format($lastMonthPercentage, 2) }}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>        
                <!-- Departments (assuming each suggestion is linked to a department) -->
                <div class="col mb-sm-2 mb-0">
                    <div class="text-medium-emphasis">Departments</div>
                    <div class="fw-semibold"> (11)</div>
                    <div class="progress progress-thin mt-2">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>        
                <!-- Monthly Suggestion Rate -->
                <div class="col mb-sm-2 mb-0">
                    <div class="text-medium-emphasis">Monthly Suggestion Rate</div>
                    <div class="fw-semibold">{{ number_format(($thisMonthSuggestions / max($lastMonthSuggestions, 1)) * 100, 2) }}%</div>
                    <div class="progress progress-thin mt-2">
                        <div class="progress-bar" role="progressbar" style="width: {{ number_format(($thisMonthSuggestions / max($lastMonthSuggestions, 1)) * 100, 2) }}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
    <!-- /.card.mb-4-->
    <script src="{{ asset('vendors/chart.js/js/chart.min.js') }}"></script>
    <script src="{{ asset('vendors/@coreui/chartjs/js/coreui-chartjs.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Data from the controller
            const dailySuggestions = @json($dailySuggestions);
            const monthlySuggestions = @json($monthlySuggestions);
            const yearlySuggestions = @json($yearlySuggestions);
        
            const ctx = document.getElementById('suggestionsChart').getContext('2d');
        
            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: Object.keys(monthlySuggestions),
                    datasets: [{
                        label: 'Suggestions',
                        data: Object.values(monthlySuggestions),
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
                chart.data.labels = Object.keys(dailySuggestions);
                chart.data.datasets[0].data = Object.values(dailySuggestions);
                chart.update();
            });
        
            document.getElementById('monthOption').addEventListener('click', function () {
                chart.data.labels = Object.keys(monthlySuggestions);
                chart.data.datasets[0].data = Object.values(monthlySuggestions);
                chart.update();
            });
        
            document.getElementById('yearOption').addEventListener('click', function () {
                chart.data.labels = Object.keys(yearlySuggestions);
                chart.data.datasets[0].data = Object.values(yearlySuggestions);
                chart.update();
            });
    
            // Download button event listener
            document.getElementById('downloadButton').addEventListener('click', function () {
                window.print();
            });
        });
    </script>
    
@endsection

