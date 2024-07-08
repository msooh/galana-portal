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
                        <div class="fs-4 fw-semibold">2 <span class="fs-6 fw-normal">10%
                            <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-bottom"></use>
                            </svg>    
                        </span></div>
                        <div>Total Suggestions</div>
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

        <!-- Completed Tasks Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card mb-4">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">2 <span class="fs-6 fw-normal">2%
                               
                                <svg class="icon">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-bottom"></use>
                                </svg>
                               </span></div>
                        <div>This Month</div>
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

        <!-- Pending Tasks Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card mb-4">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">10 <span class="fs-6 fw-normal">10%
                                
                                <svg class="icon">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-top"></use>
                                </svg>
                               </span></div>
                        <div>Last Month</div>
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

        <!-- High Risk Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card mb-4 ">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">20 <span class="fs-6 fw-normal">10%
                                
                                <svg class="icon">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-bottom"></use>
                                </svg>
                              </span></div>
                        <div>Total Boxes</div>
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
                    <h4 class="card-title mb-0">Staff Suggestions Reports</h4>
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
                <!-- Total Reports -->
                <div class="col mb-sm-2 mb-0">
                    <div class="text-medium-emphasis">Total Suggestions</div>
                    <div class="fw-semibold">100 Reports (10%)</div>
                    <div class="progress progress-thin mt-2">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 10%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <!-- High Risk -->
                <div class="col mb-sm-2 mb-0">
                    <div class="text-medium-emphasis">This Month</div>
                    <div class="fw-semibold">10 Suggestions Reports (20%)</div>
                    <div class="progress progress-thin mt-2">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 20%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <!-- Medium Risk -->
                <div class="col mb-sm-2 mb-0">
                    <div class="text-medium-emphasis">Last Month</div>
                    <div class="fw-semibold">30 Suggestion Reports (30%)</div>
                    <div class="progress progress-thin mt-2">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 30%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <!-- Low Risk Reports -->
                <div class="col mb-sm-2 mb-0">
                    <div class="text-medium-emphasis">Departments</div>
                    <div class="fw-semibold"> (15%)</div>
                    <div class="progress progress-thin mt-2">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 15%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <!-- Visit Rate -->
                <div class="col mb-sm-2 mb-0">
                    <div class="text-medium-emphasis">Monthy Suggestion Rate</div>
                    <div class="fw-semibold">50%</div>
                    <div class="progress progress-thin mt-2">
                        <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card.mb-4-->
    <script src="{{ asset('vendors/chart.js/js/chart.min.js') }}"></script>
    <script src="{{ asset('vendors/@coreui/chartjs/js/coreui-chartjs.js') }}"></script>
@endsection

