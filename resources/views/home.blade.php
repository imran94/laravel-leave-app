@extends('layouts.landingpage')
@section('content')
<div id="content" class="col-lg-10 col-sm-10">
    <!-- content starts -->
    <div class=" row">
        <div class="col-md-12">
            <a data-toggle="tooltip" class="well top-block" href="#" style="background-color: #37a7e8;    font-family: 'Helvetica Neue', Helvetica, Arial, serif;
        letter-spacing: 2px;
        text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.5);
        color: white;
        font-size: 17px;">
                <div>Notify Me & Auto Call Completion</div>
            </a>
        </div>

        <div class="col-md-3 col-sm-3 col-xs-6" style="margin-left: 137px;">
            <a data-toggle="tooltip" class="well top-block" href="#">
                {{-- <i class="glyphicon glyphicon-re blue"></i> --}}
                <div>Auto Call Revenue</div>
                <div>{{$TotalRevenue[0]->totalAcbChargedSuccess*0.35}}</div>
            </a>
        </div>


        <div class="col-md-3 col-sm-3 col-xs-6">
            <a data-toggle="tooltip" class="well top-block" href="#">
                {{-- <i class="glyphicon glyphicon-star green"></i> --}}
                <div>Notify Me Revenue</div>
                <div>{{$TotalRevenue[0]->totalNmChargedSuccess*0.25}}</div>
            </a>
        </div>

        <div class="col-md-3 col-sm-3 col-xs-6">
            <a data-toggle="tooltip" class="well top-block" href="#">
                {{-- <i class="glyphicon glyphicon-shopping-cart yellow"></i> --}}
                <div>Total Revenue</div>
                <div>
                    {{($TotalRevenue[0]->totalAcbChargedSuccess)*0.35+($TotalRevenue[0]->totalNmChargedSuccess)*0.25}}
                </div>
            </a>
        </div>

    </div>
    <div class="row">
        <div class="box col-md-12">
            <div class="box col-md-12">
                @if (\Session::has('success'))
                <div class="alert alert-danger">
                    <ul>
                        <li>{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
                @endif
                <div class="box-inner">
                    <div class="box-header well">
                    </div>
                    <div class="box-content row">
                        <div class="col-md-offset-3 col-md-6 well">
                            <form class="form-horizontal" role="form" method="get" action="ttaRevenue">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="inputKey" class="col-md-2 control-label"> Date:</label>
                                            <div class="col-md-3">
                                                <input type="text" name="sdate" value="{{Request::get('sdate')}}"
                                                       class="form-control" id="datetimepicker1">
                                                <script type="text/javascript">
                                                    $(function () {
                                                        var dateNow = new Date();
                                                        $('#datetimepicker1').datetimepicker({
                                                            useCurrent: true,
                                                            defaultDate: dateNow,
                                                            format: 'YYYY-MM-DD',


                                                        });
                                                    });
                                                </script>
                                                {{-- <input type="text" name="sdate" value="{{Request::get('sdate')}}"
                                                            class="form-control" id="datepicker"> --}}
                                            </div>
                                            <span for="inputValue" class="col-md-1 control-label">To</span>
                                            <div class="col-md-3">
                                                <input type="text" autocomplete="none" name="edate"
                                                       value="{{Request::get('edate')}}" class="form-control"
                                                       id="datetimepicker2">
                                                <script type="text/javascript">
                                                    $(function () {
                                                        var dateNow = new Date();
                                                        $('#datetimepicker2').datetimepicker({
                                                            useCurrent: true,
                                                            defaultDate: dateNow,
                                                            format: 'YYYY-MM-DD',
                                                        });
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-sm-2">
                                        <button class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                            </form>
                        </div>

                        <div class="row">
                            <div class="col-md-offset-3 col-md-6">
                                <canvas id="canvas1"></canvas>
                            </div>

                            <div class="col-md-offset-2 col-md-8">
                                <canvas id="canvas2"></canvas>
                            </div>

                            <div class="col-md-offset-3 col-md-6">
                                <canvas id="canvas3"></canvas>
                            </div>

                            <div class="col-md-offset-2 col-md-8">
                                <canvas id="canvas4"></canvas>
                            </div>

                            <div class="col-md-offset-2 col-md-8">
                                <canvas id="canvas5"></canvas>
                            </div>

                            <div class="col-md-offset-1 col-md-10">
                                <canvas id="canvas6"></canvas>
                            </div>

                            <div class="col-md-offset-1 col-md-10">
                                <canvas id="canvas7"></canvas>
                            </div>
                        </div>

                        </row>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/row-->

    <script>
        var labels = [];
        var NMrevenue = [];
        var ACBrevenue = [];
        var labels2 = [];
        var totalSubscriberGeneratingCall = [];
        var totalcallattempts = [];
        //NM charging
        var totalsubs = [];
        var totalnmOptin = [];
        var labels2 = [];
        var NotifyHourlyOptin = [];
        var NotifyHourlyChargesSuccess = [];
        //ACB charges
        var ACBoptin = [];
        var ACBsuccess = [];
        var totalCallsGenerated = [];
        var totalCallsConnected = [];



        <?php
        foreach ($ttaRevenue as $r) {
        ?>
        labels.push("<?php echo $r->dt ?>");
        NMrevenue.push("<?php echo $r->totalNmChargedSuccess * 0.2 ?>");
        ACBrevenue.push("<?php echo $r->totalAcbChargedSuccess * 0.3 ?>");
        totalsubs.push("<?php echo $r->totalSubscriberGeneratingCall ?>");
        totalnmOptin.push("<?php echo $r->totalNmOptin ?>");

        <?php }?>


        <?php
        foreach ($hourly as $r) {

        ?>
        labels2.push("<?php echo $r->dt . ' ' . $r->hour?>:00:00")
        totalSubscriberGeneratingCall.push("<?php echo $r->totalSubscriberGeneratingCall?>");
        totalcallattempts.push("<?php echo $r->totalCallsAttempted?>");
        NotifyHourlyOptin.push("<?php echo $r->totalNmOptin?>");
        NotifyHourlyChargesSuccess.push("<?php echo $r->totalNmChargedSuccess?>");
        ACBoptin.push("<?php echo $r->totalAcbOptin?>");
        ACBsuccess.push("<?php echo $r->totalAcbChargedSuccess?>");
        totalCallsGenerated.push("<?php echo $r->totalCallsGenerated?>");
        totalCallsConnected.push("<?php echo $r->totalCallsConnected?>");
        <?php
        }
        ?>

        var config1 = {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'AC_2114',
                    fill: false,
                    backgroundColor: window.chartColors.blue,
                    borderColor: window.chartColors.blue,
                    data: ACBrevenue
                }, {
                    label: 'NM_2114',
                    fill: false,
                    backgroundColor: window.chartColors.red,
                    borderColor: window.chartColors.red,
                    data: NMrevenue

                }]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'TTA Revenue Snap Shot'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Days'
                        },
                        unit: "day",
                        //format:"yyyy/MM/dd",
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 20

                        }

                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Revenue'
                        }
                    }]
                }
            }
        };
        /*
        TTA Hourly Traffic Valumn
        */


        var config2 = {
            type: 'line',
            data: {
                labels: labels2,
                datasets: [
                    {
                        label: "Subscriber Generating Calls",
                        data: totalSubscriberGeneratingCall,
                        fill: 1,
                        backgroundColor: window.chartColors.grey,
                        borderColor: window.chartColors.blue
                    },
                    {
                        label: "Total Call Attempts",
                        data: totalcallattempts,
                        fill: 0,
                        backgroundColor: window.chartColors.dark,
                        borderColor: window.chartColors.red
                    }
                ]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'TTA hourly Traffic Volumn'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [
                        {
                            scaleLabel: {
                                display: true,
                                labelString: "Time Line"
                            },
                            position: "bottom"
                        }
                    ],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        }
                    }]
                }
            }
        };

        /*
    Potential Vs. Opt-IN (Notify Me) Graph
        */

        var config3 = {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Subscriber Generating Calls',
                    fill: false,
                    backgroundColor: window.chartColors.blue,
                    borderColor: window.chartColors.blue,
                    data: totalsubs
                }, {
                    label: 'NM OptIn',
                    fill: false,
                    backgroundColor: window.chartColors.red,
                    borderColor: window.chartColors.red,
                    data: totalnmOptin

                }]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'Potential Vs. Opt-IN (Notify Me)'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Days'
                        },
                        unit: "day",
                        //format:"yyyy/MM/dd",
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 20

                        }

                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        }
                    }],

                }
            }
        };

        var config4 = {
            type: 'line',
            data: {
                labels: labels2,
                datasets: [
                    {
                        label: "Notify OptIn",
                        data: NotifyHourlyOptin,
                        fill: false,
                        backgroundColor: window.chartColors.grey,
                        borderColor: window.chartColors.blue
                    },
                    {
                        label: "Notify Charged Success",
                        data: NotifyHourlyChargesSuccess,
                        fill: 0,
                        backgroundColor: window.chartColors.dark,
                        borderColor: window.chartColors.red
                    }
                ]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'Notify Me Usage Trend'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [
                        {
                            scaleLabel: {
                                display: true,
                                labelString: "Time Line"
                            },
                            position: "bottom"
                        }
                    ],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        }
                    }]
                }
            }
        };

        var config5 = {
            type: 'line',
            data: {
                labels: labels2,
                datasets: [
                    {
                        label: "ACB OptIn",
                        data: ACBoptin,
                        fill: false,
                        backgroundColor: window.chartColors.grey,
                        borderColor: window.chartColors.blue
                    },
                    {
                        label: "ACB Charge Success",
                        data: ACBsuccess,
                        fill: false,
                        backgroundColor: window.chartColors.dark,
                        borderColor: window.chartColors.red
                    }
                ]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'Auto Call Hourly Charge Success'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [
                        {
                            scaleLabel: {
                                display: true,
                                labelString: "Time Line"
                            },
                            position: "bottom"
                        }
                    ],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        }
                    }]
                }
            }
        };

        /*
    Potential Vs. Opt-IN (Notify Me) Graph
        */
        var config6 = {
            type: 'line',
            data: {
                labels: labels2,
                datasets: [
                    {
                        label: "ACB OptIn",
                        data: ACBoptin,
                        fill: false,
                        backgroundColor: window.chartColors.grey,
                        borderColor: window.chartColors.blue
                    },
                    {
                        label: "ACB Charged Success",
                        data: ACBsuccess,
                        fill: false,
                        backgroundColor: window.chartColors.dark,
                        borderColor: window.chartColors.red
                    },
                    {
                        label: "ACB Calls Generated",
                        data: totalCallsGenerated,
                        fill: false,
                        backgroundColor: window.chartColors.dark,
                        borderColor: window.chartColors.green
                    },
                    {
                        label: "ACB Calls Connected",
                        data: totalCallsConnected,
                        fill: false,
                        backgroundColor: window.chartColors.dark,
                        borderColor: window.chartColors.purple
                    }
                ]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'Auto Call Hourly Trend'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [
                        {
                            scaleLabel: {
                                display: true,
                                labelString: "Time Line"
                            },
                            position: "bottom"
                        }
                    ],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        }
                    }]
                }
            }
        };

        window.onload = function () {
            var ctx1 = document.getElementById('canvas1').getContext('2d');
            window.myLine1 = new Chart(ctx1, config1);
            var ctx2 = document.getElementById('canvas2').getContext('2d');
            window.myLine2 = new Chart(ctx2, config2);
            var ctx3 = document.getElementById('canvas3').getContext('2d');
            window.myLine3 = new Chart(ctx3, config3);
            var ctx4 = document.getElementById('canvas4').getContext('2d');
            window.myLine4 = new Chart(ctx4, config4);
            var ctx5 = document.getElementById('canvas5').getContext('2d');
            window.myLine5 = new Chart(ctx5, config5);
            var ctx6 = document.getElementById('canvas6').getContext('2d');
            window.myLine6 = new Chart(ctx6, config6);


        };


    </script>

    @endsection
