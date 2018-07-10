<?php
include __DIR__ . '/../src/connect.php';
include './php/page_functions.php';
if (mysqli_connect_errno()) {
    echo "Connect failed";
}
//http://cidse-gputil.cidse.dhcp.asu.edu/test.php?compNameRedirect=42
//This will spit out 42 into the window
//This means we can specify directly with links
$id = $_GET['id'];
$user = $_GET['user'];
$question = $_GET['q'];
$date = $_GET['date'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
          content="GPUtilization. A website dedicated to helping IT gather information on GPU utilizations across the network">
    <meta name="author" content="Nicholas Finch">
    <link rel="icon" href="https://getbootstrap.com/favicon.ico">

    <title>Dashboard for GPUtil</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
    <style type="text/css">/* Chart.js */
        @-webkit-keyframes chartjs-render-animation {
            from {
                opacity: 0.99
            }
            to {
                opacity: 1
            }
        }

        @keyframes chartjs-render-animation {
            from {
                opacity: 0.99
            }
            to {
                opacity: 1
            }
        }

        .chartjs-render-monitor {
            -webkit-animation: chartjs-render-animation 0.001s;
            animation: chartjs-render-animation 0.001s;
        }</style>
</head>

<body>
<form action="">
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="index.php">ASU - GPU utilizations</a>
        <input class="form-control form-control-dark w-100" placeholder="Search" aria-label="Search" type="text"
               name="q">
        <!--    Sign in button. Not applicable quite yet    -->
        <!--        <ul class="navbar-nav px-3">-->
        <!--            <li class="nav-item text-nowrap">-->
        <!--                <a class="nav-link" href="#">Sign out</a>-->
        <!--            </li>-->
        <!--        </ul>-->
    </nav>
</form>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <?php setSideBarNav($cxn, $question) ?>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <div style="position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"
                 class="chartjs-size-monitor">
                <div class="chartjs-size-monitor-expand"
                     style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                    <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                </div>
                <div class="chartjs-size-monitor-shrink"
                     style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                    <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                </div>
            </div>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <button class="btn btn-sm btn-outline-secondary">Share</button>
                        <button class="btn btn-sm btn-outline-secondary">Export</button>
                    </div>
                    <form action="" style="margin-bottom: 0px;">
                        <div class="btn-group mr-2">
                            <input type="date" name="date" class="form-control">
                            <button type="submit" class="btn btn-sm btn-outline-secondary">Submit</button>
                        </div>
                    </form>

                </div>
            </div>

            <canvas class="my-4 chartjs-render-monitor" id="myChart" width="1240" height="523"
                    style="display: block; width: 1240px; height: 523px;"></canvas>

            <h2><?php
                if ($user != null) {
                    echo $id . '-' . $user;
                } else {
                    echo $id;
                }
                ?>
            </h2>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>Computer Name</th>
                        <th>usage_0</th>
                        <th>usage_10</th>
                        <th>usage_20</th>
                        <th>usage_30</th>
                        <th>usage_40</th>
                        <th>usage_50</th>
                        <th>usage_60</th>
                        <th>usage_70</th>
                        <th>usage_80</th>
                        <th>usage_90</th>
                        <th>User</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $comp_result = queryComputerUsages($cxn, $user, $date, $id);
                    while ($user_name = mysqli_fetch_array($comp_result)) {
                        echo "<tr>";
                        table_td($user_name['ComputerName']);
                        table_td($user_name['usage_0']);
                        table_td($user_name['usage_10']);
                        table_td($user_name['usage_20']);
                        table_td($user_name['usage_30']);
                        table_td($user_name['usage_40']);
                        table_td($user_name['usage_50']);
                        table_td($user_name['usage_60']);
                        table_td($user_name['usage_70']);
                        table_td($user_name['usage_80']);
                        table_td($user_name['usage_90']);
                        table_td($user_name['users']);
                        table_td($user_name['OrderDate']);
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery-3.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.js"></script>

<!-- Icons -->
<script src="js/feather.js"></script>
<script>
    feather.replace()
</script>

<!-- Graphs -->
<script src="js/Chart.js"></script>
<script>
    // set up away to

    const ctx = document.getElementById("myChart");
    new Chart(ctx, {
        type: 'line',
        data: {
            // "2018-06-07", "2018-06-08", "2018-06-09", "2018-06-10", "2018-06-11", "2018-06-12", "2018-06-13", "2018-06-14"
            labels: [
                <?php
                $comp_result = queryComputerUsages($cxn, $user, $id);
                while ($user_name = mysqli_fetch_array($comp_result)) {
                    echo '"' . $user_name['OrderDate'] . '"' . ',';
                }
                ?>
            ],
            datasets: [{
                data: [51.03, 42.14, 40.94, 46.23, 37.46, 40.3, 50.31, 45.36
                ],
                lineTension: 0,
                backgroundColor: 'transparent',
                borderColor: '#8c1d40',
                borderWidth: 4,
                pointBackgroundColor: '#8c1d40'
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    }
                }]
            },
            legend: {
                display: false,
            }
        }
    });
</script>


</body>
</html>