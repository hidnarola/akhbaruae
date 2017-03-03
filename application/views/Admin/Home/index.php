<script src="assets/js/bootstrap/bootstrap-datepicker.js" type="text/javascript"></script>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Dashboard</h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href=""><i class="icon-home2 position-left"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-body border-top-danger text-center">
                <h6 class="no-margin text-semibold">Total active users</h6>
                <p class="content-group-sm text-muted"></p>
                <ul class="fab-menu fab-menu-top" data-fab-toggle="click">
                    <li>
                        <a class="fab-menu-btn btn bg-teal-400 btn-float btn-rounded btn-icon count">
                            <?php echo $total_users; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-body border-top-danger text-center">
                <h6 class="no-margin text-semibold">Total blocked users</h6>
                <p class="content-group-sm text-muted"></p>

                <ul class="fab-menu fab-menu-top" data-fab-toggle="click">
                    <li>
                        <a class="fab-menu-btn btn btn-danger btn-float btn-rounded btn-icon count">
                            <?php echo $total_blocked_users; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-body border-top-danger text-center">
                <h6 class="no-margin text-semibold">Total users</h6>
                <p class="content-group-sm text-muted"></p>
                <ul class="fab-menu fab-menu-top" data-fab-toggle="click">
                    <li>
                        <a class="fab-menu-btn btn bg-brown btn-float btn-rounded btn-icon count">
                            <?php echo $total_users + $total_blocked_users; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Sales stats -->
        <div class="panel panel-flat">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-3">
                        <h2 class="panel-title">Users Report</h2>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-inline pull-right">
                            <div class="form-group">
                                <input name="datepicker" class="form-control" id="search_users_text" class="date-picker" />
                            </div>
                            <button type="submit" class="btn btn-primary" id="search_users" data-type="search_users">Search</button>
                        </div>
                    </div>    
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div  id="chartContainer1" style="width: 100%; height: 500px; margin-bottom: 10px"></div> 
                    </div>
                </div>
            </div>
        </div>
        <!-- /sales stats -->
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-body border-top-danger text-center">
                <h6 class="no-margin text-semibold">Total active spots</h6>
                <p class="content-group-sm text-muted"></p>
                <ul class="fab-menu fab-menu-top" data-fab-toggle="click">
                    <li>
                        <a class="fab-menu-btn btn bg-teal-400 btn-float btn-rounded btn-icon count">
                            <?php echo $total_spots; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-body border-top-danger text-center">
                <h6 class="no-margin text-semibold">Total pending approval spots</h6>
                <p class="content-group-sm text-muted"></p>

                <ul class="fab-menu fab-menu-top" data-fab-toggle="click">
                    <li>
                        <a class="fab-menu-btn btn btn-danger btn-float btn-rounded btn-icon count">
                            <?php echo $total_pending_spots; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-body border-top-danger text-center">
                <h6 class="no-margin text-semibold">Total spots</h6>
                <p class="content-group-sm text-muted"></p>
                <ul class="fab-menu fab-menu-top" data-fab-toggle="click">
                    <li>
                        <a class="fab-menu-btn btn bg-brown btn-float btn-rounded btn-icon count">
                            <?php echo $total_spots + $total_pending_spots; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Sales stats -->
        <div class="panel panel-flat">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-3">
                        <h2 class="panel-title">Spots Report</h2>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-inline pull-right">
                            <div class="form-group">
                                <input name="datepicker" class="form-control" id="search_spots_text" class="date-picker" />
                            </div>
                            <button type="submit" class="btn btn-primary" id="search_spots" data-type="search_spots">Search</button>
                        </div>
                    </div>    
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div  id="chartContainer2" style="width: 100%; height: 500px; margin-bottom: 10px;"></div> 
                    </div>
                </div>
            </div>
        </div>
        <!-- /sales stats -->
    </div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    $(document).ready(function () {
        $('.count').each(function () {
            $(this).prop('Counter',0).animate({
                Counter: $(this).text()
            }, {
                duration: 4000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });

        var dateToday = new Date();
        $("#search_users_text").datepicker({
            format: "mm-yyyy",
            minDate: 0,
            viewMode: "months",
            minViewMode: "months",
            endDate: new Date
        });
        $("#search_spots_text").datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minDate: 0,
            minViewMode: "months",
            endDate: new Date
        });
        load_users_chart();
        load_spots_chart();
    });
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(load_spots_chart);
    google.charts.setOnLoadCallback(load_users_chart);
    $(document).on('click', '#search_users, #search_spots', function () {
        if ($(this).data('type') == 'search_spots') {
            load_spots_chart();
        } else {
            load_users_chart();
        }
    });

    function load_users_chart() {
        $.ajax({
            url: "<?php site_url() ?>admin/home/load_dashboard_graphs_users",
            type: "POST",
            data: {'type': 'users', date: $('#search_users_text').val()},
            success: function (result) {
                data = JSON.parse(result);
                user_chart_array = [];
                $.each(data, function (i, item) {
                    date = new Date(item.created_date);
                    my_date = (date.getMonth() + 1) + '/' + date.getDate() + '/' + date.getFullYear();
                    test = [];
                    test.push(my_date, parseInt(item.user_count));
                    user_chart_array.push(test);
                });
                drawChart(user_chart_array);
            }
        });
    }

    function load_spots_chart() {
        $.ajax({
            url: "<?php site_url() ?>admin/home/load_dashboard_graphs_spots",
            type: "POST",
            data: {'type': 'spots', date: $('#search_spots_text').val()},
            success: function (result) {
                data1 = JSON.parse(result);
                spots_chart_array = [];
                $.each(data1, function (i, item) {
                    date = new Date(item.created_date);
                    my_date = (date.getMonth() + 1) + '/' + date.getDate() + '/' + date.getFullYear();
                    test = [];
                    test.push(my_date, parseInt(item.spot_count));
                    spots_chart_array.push(test);
                });
                drawChart2(spots_chart_array);
            }
        });
    }

    function drawChart(user_chart_array) {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Time of Day');
        data.addColumn('number', 'Total Users');
        data.addRows(user_chart_array);
        var options = {
            hAxis: {
                format: 'M/d/yy',
                gridlines: {count: 31},
                title: 'Date',  titleTextStyle: {color: '#fff'}
            },
            vAxis: {
                gridlines: {color: 'none'},
                minValue: 0,
                title: 'Number of users',  titleTextStyle: {color: '#fff'}
            },
            backgroundColor: '#cccccc'
        };
        // Options
        var options = {
            fontName: 'Roboto',
            curveType: 'function',
            fontSize: 12,
            areaOpacity: 0.4,
            chartArea: {
                left: '5%',
                width: '90%',
                height: 350
            },
            pointSize: 4,
            tooltip: {
                textStyle: {
                    fontName: 'Roboto',
                    fontSize: 13
                }
            },
            vAxis: {
                title: 'Number of users',
                titleTextStyle: {
                    fontSize: 13,
                    italic: false
                },
                gridarea:{
                    color: '#e5e5e5',
                    count: 10
                },
                minValue: 0
            },
            legend: {
                position: 'top',
                alignment: 'end',
                textStyle: {
                    fontSize: 12
                }
            },
            hAxis: {
                format: 'M/d/yy',
                gridlines: {count: 31},
                title: 'Date',
                titleTextStyle: {
                    fontSize: 13,
                    italic: false
                },
            },
        };
        var chart = new google.visualization.AreaChart(document.getElementById('chartContainer1'));
        chart.draw(data, options);
    }

    function drawChart2(spots_chart_array) {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Time of Day');
        data.addColumn('number', 'Total Spots');
        data.addRows(spots_chart_array);
        var options = {
            hAxis: {
                format: 'M/d/yy',
                gridlines: {count: 31},
                title: 'Date',  titleTextStyle: {color: '#fff'}
            },
            vAxis: {
                gridlines: {color: 'none'},
                minValue: 0,
                title: 'Number of spots',  titleTextStyle: {color: '#fff'}
            },
            backgroundColor: '#cccccc'
        };

        // Options
        var options = {
            fontName: 'Roboto',
            curveType: 'function',
            fontSize: 12,
            areaOpacity: 0.4,
            chartArea: {
                left: '5%',
                width: '90%',
                height: 350
            },
            pointSize: 4,
            tooltip: {
                textStyle: {
                    fontName: 'Roboto',
                    fontSize: 13
                }
            },
            vAxis: {
                title: 'Number of spots',
                titleTextStyle: {
                    fontSize: 13,
                    italic: false
                },
                gridarea:{
                    color: '#e5e5e5',
                    count: 10
                },
                minValue: 0
            },
            legend: {
                position: 'top',
                alignment: 'end',
                textStyle: {
                    fontSize: 12
                }
            },
            hAxis: {
                format: 'M/d/yy',
                gridlines: {count: 31},
                title: 'Date',
                titleTextStyle: {
                    fontSize: 13,
                    italic: false
                },
            },
        };
        var chart = new google.visualization.AreaChart(document.getElementById('chartContainer2'));
        chart.draw(data, options);
    }
</script>