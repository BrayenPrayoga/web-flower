@extends('template.main')

@section('css')

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-home"></i>
                </span> Dashboard
            </h3>
        </div>
        <div class="row" style="display:none;">
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                    <div class="card-body">
                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Total Penjualan <i
                                class="mdi mdi-chart-line mdi-24px float-right"></i>
                        </h4>
                        <h2 class="mb-5">$ 15,0000</h2>
                        <h6 class="card-text"> </h6>
                    </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                    <div class="card-body">
                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Weekly Orders <i
                                class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                        </h4>
                        <h2 class="mb-5">45,6334</h2>
                        <h6 class="card-text">Decreased by 10%</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                    <div class="card-body">
                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Visitors Online <i
                                class="mdi mdi-diamond mdi-24px float-right"></i>
                        </h4>
                        <h2 class="mb-5">95,5741</h2>
                        <h6 class="card-text">Increased by 5%</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div id="chart-column"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div id="chart-pie"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
<script>
    $(document).ready( function () {
        chartPie();
        chartColumn();
    });

    function chartPie(){
        Highcharts.chart('chart-pie', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45
                }
            },
            title: {
                text: 'Beijing 2022 gold medals by country',
                align: 'left'
            },
            subtitle: {
                text: '3D donut in Highcharts',
                align: 'left'
            },
            plotOptions: {
                pie: {
                    innerSize: 100,
                    depth: 45
                }
            },
            series: [{
                name: 'Medals',
                data: [
                    ['Norway', 16],
                    ['Germany', 12],
                    ['USA', 8],
                    ['Sweden', 8],
                    ['Netherlands', 8],
                    ['ROC', 6],
                    ['Austria', 7],
                    ['Canada', 4],
                    ['Japan', 3]

                ]
            }]
        });
    }

    function chartColumn(){
        Highcharts.chart('chart-column', {
            chart: {
                type: 'column',
                options3d: {
                    enabled: true,
                    alpha: 15,
                    beta: 15,
                    viewDistance: 25,
                    depth: 40
                }
            },

            title: {
                text: ' Electricity production in countries, grouped by continent',
                align: 'left'
            },

            xAxis: {
                labels: {
                    skew3d: true,
                    style: {
                        fontSize: '16px'
                    }
                }
            },

            yAxis: {
                allowDecimals: false,
                min: 0,
                title: {
                    text: 'TWh',
                    skew3d: true,
                    style: {
                        fontSize: '16px'
                    }
                }
            },

            tooltip: {
                headerFormat: '<b>{point.key}</b><br>',
                pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: {point.y} / {point.stackTotal}'
            },

            plotOptions: {
                series: {
                    pointStart: 2016
                },
                column: {
                    stacking: 'normal',
                    depth: 40
                }
            },

            series: [{
                name: 'South Korea',
                data: [563, 567, 590, 582, 571],
                stack: 'Asia'
            }, {
                name: 'Germany',
                data: [650, 654, 643, 612, 572],
                stack: 'Europe'
            }, {
                name: 'Saudi Arabia',
                data: [368, 378, 378, 367, 363],
                stack: 'Asia'
            }, {
                name: 'France',
                data: [564, 562, 582, 571, 533],
                stack: 'Europe'
            }]
        });
    }
</script>
@endsection