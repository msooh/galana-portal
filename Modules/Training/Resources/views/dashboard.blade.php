@extends('training::layouts.master')

@section('content')
<div class="container-lg">
    <!-- Cards for Training Metrics -->
    <div class="row">
        <!-- Total Training Sessions Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card mb-4">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">{{$dashboardData['totalTrainings']}} <span class="fs-6 fw-normal">({{ number_format($dashboardData['trainingPercentageChange'], 2) }}%
                                @if ($dashboardData['trainingPercentageChange'] > 0)
                                <i class="fa fa-arrow-up"></i>
                                @else
                                <i class="fa fa-arrow-down"></i>
                                @endif
                                )</span></div>
                        <div>Total Training Sessions</div>
                    </div>
                </div>
                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                    <canvas class="chart" id="card-chart1" height="70"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Total Trainees Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card mb-4">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">{{$dashboardData['totalTrainees']}} <span class="fs-6 fw-normal">({{ number_format($dashboardData['traineesPercentageChange'], 2) }}%
                                @if ($dashboardData['traineesPercentageChange'] > 0)
                                <i class="fa fa-arrow-up"></i>
                                @else
                                <i class="fa fa-arrow-down"></i>
                                @endif
                                )</span></div>
                        <div>Total Trainees</div>
                    </div>
                </div>
                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                    <canvas class="chart" id="card-chart2" height="70"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Completed Trainings Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card mb-4">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">{{$dashboardData['completedTrainings']}} <span class="fs-6 fw-normal">({{ number_format($dashboardData['completedPercentage'], 2) }}%
                                @if ($dashboardData['completedPercentage'] > 0)
                                <i class="fa fa-arrow-up"></i>
                                @else
                                <i class="fa fa-arrow-down"></i>
                                @endif
                                )</span></div>
                        <div>Completed Trainings</div>
                    </div>
                </div>
                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                    <canvas class="chart" id="card-chart3" height="70"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Pending Trainings Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card mb-4">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">{{$dashboardData['pendingTrainings']}} <span class="fs-6 fw-normal">({{ number_format($dashboardData['pendingPercentage'], 2) }}%
                                @if ($dashboardData['pendingPercentage'] > 0)
                                <i class="fa fa-arrow-up"></i>
                                @else
                                <i class="fa fa-arrow-down"></i>
                                @endif
                                )</span></div>
                        <div>Pending Trainings</div>
                    </div>
                </div>
                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                    <canvas class="chart" id="card-chart4" height="70"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- Training Performance Stats -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title mb-0">Training Performance</h4>
                    <div class="small text-medium-emphasis">January - December</div>
                </div>
                <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
                    <div class="btn-group btn-group-toggle mx-3" data-coreui-toggle="buttons">
                        <input class="btn-check" id="dayOption" type="radio" name="options" autocomplete="off">
                        <label class="btn btn-outline-secondary" for="dayOption">Day</label>
                        <input class="btn-check" id="monthOption" type="radio" name="options" autocomplete="off" checked=""/>
                        <label class="btn btn-outline-secondary" for="monthOption">Month</label>
                        <input class="btn-check" id="yearOption" type="radio" name="options" autocomplete="off">
                        <label class="btn btn-outline-secondary" for="yearOption">Year</label>
                    </div>
                    <button class="btn btn-primary" type="button" id="downloadButton">
                        <i class="fa fa-cloud-download-alt"></i>
                    </button>                
                </div>
            </div>
            <div class="c-chart-wrapper mt-3 mx-3" style="height:250px;">
                <canvas class="chart" id="trainingPerformanceChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        // Data from the controller
        const dashboardData = @json($dashboardData);  // This contains all your data

        // Assuming dashboardData.trainingsPerMonth is an object where each key is a month (e.g., "2025-01") 
        const labels = Object.keys(dashboardData.trainingsPerMonth).map(month => {
            // Format the month key into a readable label (e.g., "January" or "2025-01")
            const date = new Date(month);  
            const options = { year: 'numeric', month: 'long' };
            return date.toLocaleDateString('en-US', options); // Format to 'January 2025' or '2025-01'
        });

        // Get the context for the training performance chart
        const ctx = document.getElementById('trainingPerformanceChart').getContext('2d');

        // Create the chart
        const trainingPerformanceChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,  // This uses the formatted labels
                datasets: [{
                    label: 'Training Performance',
                    data: Object.values(dashboardData.trainingsPerMonth),  // Pass the actual data
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.2)',
                    fill: true,
                    tension: 0.4,
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

        // Update chart based on selected period (Day, Month, Year)
        const dayOption = document.getElementById('dayOption');
        const monthOption = document.getElementById('monthOption');
        const yearOption = document.getElementById('yearOption');

        function updateChart(period) {
            // Example logic to filter data based on the selected period (Day, Month, Year)
            let filteredData = [];
            let filteredLabels = [];

            switch (period) {
                case 'day':
                    filteredData = dashboardData.trainingsPerDay;
                    filteredLabels = Object.keys(dashboardData.trainingsPerDay);
                    break;
                case 'month':
                    filteredData = dashboardData.trainingsPerMonth;
                    filteredLabels = Object.keys(dashboardData.trainingsPerMonth);
                    break;
                case 'year':
                    filteredData = dashboardData.trainingsPerYear;
                    filteredLabels = Object.keys(dashboardData.trainingsPerYear);
                    break;
            }

            // Update the chart with the new filtered data
            trainingPerformanceChart.data.labels = filteredLabels.map(label => {
                const date = new Date(label);
                if (period === 'day') {                
                    return date.toLocaleDateString('en-CA');  // This gives the format: "2025-02-06"
                } else if (period === 'month') {              
                    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long' });
                } else {                
                    return date.getFullYear();  
                }
            });

            trainingPerformanceChart.data.datasets[0].data = Object.values(filteredData);
            trainingPerformanceChart.update();
        }
        // Download button event listener
        document.getElementById('downloadButton').addEventListener('click', function () {
            window.print();
        });

        // Add event listeners to update chart when user changes period
        dayOption.addEventListener('change', function () {
            if (dayOption.checked) {
                updateChart('day');
            }
        });

        monthOption.addEventListener('change', function () {
            if (monthOption.checked) {
                updateChart('month');
            }
        });

        yearOption.addEventListener('change', function () {
            if (yearOption.checked) {
                updateChart('year');
            }
        });
    });
    </script>

@endsection
