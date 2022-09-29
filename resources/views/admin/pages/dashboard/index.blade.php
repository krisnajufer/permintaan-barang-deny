@extends('admin.layouts.app')

@section('title')
    Dashboard
@endsection

@push('after-style')
    <link rel="stylesheet" href="{{ asset('StarAdmin2/assets/js/select.dataTables.min.css') }}">
@endpush

@push('after-script')
    <script src="{{ asset('StarAdmin2/assets/js/jquery.cookie.js') }}"></script>
    <script src="{{ asset('StarAdmin2/assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('StarAdmin2/assets/js/Chart.roundedBarCharts.js') }}"></script>
    <script src="{{ asset('StarAdmin2/assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('StarAdmin2/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('StarAdmin2/assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
@endpush

@section('content')
    <div class="col-sm-12">
        <div class="home-tab">
            <div class="tab-content tab-content-basic border-top">
                <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="statistics-details d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="statistics-title">Bounce Rate</p>
                                    <h3 class="rate-percentage">32.53%</h3>
                                    <p class="text-danger d-flex"><i class="mdi mdi-menu-down"></i><span>-0.5%</span></p>
                                </div>
                                <div>
                                    <p class="statistics-title">Page Views</p>
                                    <h3 class="rate-percentage">7,682</h3>
                                    <p class="text-success d-flex"><i class="mdi mdi-menu-up"></i><span>+0.1%</span></p>
                                </div>
                                <div>
                                    <p class="statistics-title">New Sessions</p>
                                    <h3 class="rate-percentage">68.8</h3>
                                    <p class="text-danger d-flex"><i class="mdi mdi-menu-down"></i><span>68.8</span></p>
                                </div>
                                <div class="d-none d-md-block">
                                    <p class="statistics-title">Avg. Time on Site</p>
                                    <h3 class="rate-percentage">2m:35s</h3>
                                    <p class="text-success d-flex"><i class="mdi mdi-menu-down"></i><span>+0.8%</span></p>
                                </div>
                                <div class="d-none d-md-block">
                                    <p class="statistics-title">New Sessions</p>
                                    <h3 class="rate-percentage">68.8</h3>
                                    <p class="text-danger d-flex"><i class="mdi mdi-menu-down"></i><span>68.8</span></p>
                                </div>
                                <div class="d-none d-md-block">
                                    <p class="statistics-title">Avg. Time on Site</p>
                                    <h3 class="rate-percentage">2m:35s</h3>
                                    <p class="text-success d-flex"><i class="mdi mdi-menu-down"></i><span>+0.8%</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 d-flex flex-column">
                            <div class="row flex-grow">
                                <div class="col-12 grid-margin stretch-card">
                                    <div class="card card-rounded">
                                        <div class="card-body">
                                            <div class="d-sm-flex justify-content-between align-items-start">
                                                <div>
                                                    <h4 class="card-title card-title-dash">Market Overview</h4>
                                                    <p class="card-subtitle card-subtitle-dash">Lorem ipsum dolor sit amet
                                                        consectetur adipisicing elit</p>
                                                </div>
                                            </div>
                                            <div class="d-sm-flex align-items-center mt-1 justify-content-between">
                                                <div class="d-sm-flex align-items-center mt-4 justify-content-between">
                                                    <h2 class="me-2 fw-bold">$36,2531.00</h2>
                                                    <h4 class="me-2">USD</h4>
                                                    <h4 class="text-success">(+1.37%)</h4>
                                                </div>
                                                <div class="me-3 ">
                                                    <div id="marketing-overview-legend"></div>
                                                </div>
                                            </div>
                                            <div class="chartjs-bar-wrapper mt-3">
                                                <canvas id="marketingOverview"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        console.log("{{ $data }}");
        data = "{{ $data }}";

        var marketingOverviewChart = document.getElementById("marketingOverview").getContext('2d');
        var marketingOverviewData = {
            labels: ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"],
            datasets: [{
                label: 'Last week',
                data: [data],
                backgroundColor: "#52CDFF",
                borderColor: [
                    '#52CDFF',
                ],
                borderWidth: 0,
                fill: true, // 3: no fill

            }, {
                label: 'This week',
                data: [215, 290, 210, 250, 290, 230, 290, 210, 280, 220, 190, 300],
                backgroundColor: "#1F3BB3",
                borderColor: [
                    '#1F3BB3',
                ],
                borderWidth: 0,
                fill: true, // 3: no fill
            }]
        };

        var marketingOverviewOptions = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    gridLines: {
                        display: true,
                        drawBorder: false,
                        color: "#F0F0F0",
                        zeroLineColor: '#F0F0F0',
                    },
                    ticks: {
                        beginAtZero: true,
                        autoSkip: true,
                        maxTicksLimit: 5,
                        fontSize: 10,
                        color: "#6B778C"
                    }
                }],
                xAxes: [{
                    stacked: true,
                    barPercentage: 0.35,
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },
                    ticks: {
                        beginAtZero: false,
                        autoSkip: true,
                        maxTicksLimit: 12,
                        fontSize: 10,
                        color: "#6B778C"
                    }
                }],
            },
            legend: false,
            legendCallback: function(chart) {
                var text = [];
                text.push('<div class="chartjs-legend"><ul>');
                for (var i = 0; i < chart.data.datasets.length; i++) {
                    console.log(chart.data.datasets[i]); // see what's inside the obj.
                    text.push('<li class="text-muted text-small">');
                    text.push('<span style="background-color:' + chart.data.datasets[i].borderColor + '">' +
                        '</span>');
                    text.push(chart.data.datasets[i].label);
                    text.push('</li>');
                }
                text.push('</ul></div>');
                return text.join("");
            },

            elements: {
                line: {
                    tension: 0.4,
                }
            },
            tooltips: {
                backgroundColor: 'rgba(31, 59, 179, 1)',
            }
        }
        var marketingOverview = new Chart(marketingOverviewChart, {
            type: 'bar',
            data: marketingOverviewData,
            options: marketingOverviewOptions
        });
        document.getElementById('marketing-overview-legend').innerHTML = marketingOverview.generateLegend();
    </script>
@endsection
