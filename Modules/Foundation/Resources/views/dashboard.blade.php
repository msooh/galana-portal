@extends('foundation::layouts.master')

@section('content')
<div class="container-lg">
    <!-- Cards for Schools, Students, and Performance -->
    <div class="row">
        <!-- Total Schools Card -->
        <div class="col-sm-6 col-lg-3">
            <a href="{{ route('schools.index') }}" class="card-link">
                <div class="card mb-4">
                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fs-4 fw-semibold">{{ $totalSchools }} <span class="fs-6 fw-normal">{{ number_format(100, 2) }}%
                                <svg class="icon">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-top"></use>
                                </svg>
                            </span></div>
                            <div>Total Schools</div>
                        </div>
                        <!-- Dropdown button -->
                        <div class="dropdown">
                            <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg class="icon">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                                </svg>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                        <!-- Chart for Total Schools -->
                        <canvas id="total-schools-chart" height="70"></canvas>
                    </div>
                </div>
            </a>
        </div>
        <!-- /.col-->

        <!-- Total Students Card -->
        <div class="col-sm-6 col-lg-3">
            <a href="{{ route('students.index') }}" class="card-link">
                <div class="card mb-4">
                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fs-4 fw-semibold">{{ $totalStudents }} <span class="fs-6 fw-normal">{{ number_format(100, 2) }}%
                                <svg class="icon">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-top"></use>
                                </svg>
                            </span></div>
                            <div>Total Students</div>
                        </div>
                        <!-- Dropdown button -->
                        <div class="dropdown">
                            <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg class="icon">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                                </svg>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <div class="c-chart-wrapper mt-3" style="height:70px;">
                        <canvas class="chart" id="student-chart" height="70"></canvas>
                    </div>
                </div>
            </a>
        </div>
        <!-- /.col-->

        <!-- Performance Overview Card -->
        <div class="col-sm-6 col-lg-3">
            <a href="{{ route('performances.index') }}" class="card-link">
                <div class="card mb-4">
                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fs-4 fw-semibold">{{ $averageMidTermScore }} <span class="fs-6 fw-normal">{{ number_format($averageMidTermScore / 100, 2) }}%
                                <svg class="icon">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-top"></use>
                                </svg>
                            </span></div>
                            <div>Av Mid-Term Scores</div>
                        </div>
                        <!-- Dropdown button -->
                        <div class="dropdown">
                            <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg class="icon">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                                </svg>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                        <canvas class="chart" id="performance-chart" height="70"></canvas>
                    </div>
                </div>
            </a>
        </div>
        <!-- /.col-->

        <!-- School Performance Card -->
        <div class="col-sm-6 col-lg-3">
            <a href="#" class="card-link">
                <div class="card mb-4">
                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fs-4 fw-semibold"> <span class="fs-6 fw-normal">{{ number_format($topPerformingSchoolPercentage, 2) }}%
                                <svg class="icon">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-top"></use>
                                </svg>
                            </span></div>
                            <div>Av End-Term Scores</div>
                        </div>
                        <!-- Dropdown button -->
                        <div class="dropdown">
                            <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg class="icon">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                                </svg>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                        <canvas class="chart" id="school-performance-chart" height="70"></canvas>
                    </div>
                </div>
            </a>
        </div>
        <!-- /.col-->
    </div>
    <!-- /.row-->

    <!-- Other statistics -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title mb-0">Student and School Performance</h4>
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
                <canvas class="chart" id="studentPerformanceChart"></canvas>
            </div>
        </div>
        <div class="card-footer">
            <div class="row row-cols-1 row-cols-md-5 text-center">
                <!-- Total Students -->
                <div class="col mb-sm-2 mb-0">
                    <div class="text-medium-emphasis">Total Students</div>
                    <div class="fw-semibold">{{ $totalStudents }} Students ({{ $percentageIncrease }}% Increase)</div>
                </div>
                <!-- Total Schools -->
                <div class="col mb-sm-2 mb-0">
                    <div class="text-medium-emphasis">Total Schools</div>
                    <div class="fw-semibold">{{ $totalSchools }}</div>
                </div>
                <!-- Top Performing School -->
                <div class="col mb-sm-2 mb-0">
                    <div class="text-medium-emphasis">Top Performing School</div>
                    <div class="fw-semibold">{{ $topPerformingSchool }}</div>
                </div>
                <!-- Average Mid Term Scores -->
                <div class="col mb-sm-2 mb-0">
                    <div class="text-medium-emphasis">Average Mid Term Scores</div>
                    <div class="fw-semibold">{{ $averageMidTermScore }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/chart.min.js') }}"></script>
<script>
    // Total Schools Chart
    var ctxSchools = document.getElementById('total-schools-chart').getContext('2d');
    new Chart(ctxSchools, {
        type: 'pie',
        data: {
            labels: ['Schools'],
            datasets: [{
                data: [{{ $totalSchools }}],
                backgroundColor: ['#007bff']
            }]
        }
    });

    // Student Chart
    var ctxStudents = document.getElementById('student-chart').getContext('2d');
    new Chart(ctxStudents, {
        type: 'bar',
        data: {
            labels: ['Students'],
            datasets: [{
                data: [{{ $totalStudents }}],
                backgroundColor: ['#28a745']
            }]
        }
    });

    // Performance Chart
    var ctxPerformance = document.getElementById('performance-chart').getContext('2d');
    new Chart(ctxPerformance, {
        type: 'line',
        data: {
            labels: ['Performance'],
            datasets: [{
                data: [{{ $averageMidTermScore }}],
                backgroundColor: 'rgba(255, 193, 7, 0.2)',
                borderColor: '#ffc107',
                borderWidth: 1
            }]
        }
    });

    // School Performance Chart
    var ctxSchoolPerformance = document.getElementById('school-performance-chart').getContext('2d');
    new Chart(ctxSchoolPerformance, {
        type: 'doughnut',
        data: {
            labels: ['Top Performing School'],
            datasets: [{
                data: [{{ $topPerformingSchoolPercentage }}],
                backgroundColor: ['#dc3545']
            }]
        }
    });

    // Overall Student Performance Chart
    var ctxStudentPerformance = document.getElementById('studentPerformanceChart').getContext('2d');
    new Chart(ctxStudentPerformance, {
        type: 'bar',
        data: {
            labels: ['Performance'],
            datasets: [{
                data: [{{ $averageMidTermScore }}],
                backgroundColor: '#007bff'
            }]
        }
    });
</script>
@endpush
