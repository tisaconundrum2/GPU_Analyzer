<?php
include __DIR__ . '/../src/connect.php';
if (mysqli_connect_errno()) {
    echo "Connect failed: ";
    echo $mysqli_connect_error();
}
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
<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">ASU - GPU utilizations</a>
    <input class="form-control form-control-dark w-100" placeholder="Search" aria-label="Search" type="text">
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="#">Sign out</a>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <?php
                    $result = mysqli_query($cxn, "SELECT DISTINCT ComputerName FROM computers");
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<li class=\"nav-item\">";
                        echo "<a class=\"nav-link\" href=\"#\">";
                        echo "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\"";
                        echo "fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\"";
                        echo "stroke-linejoin=\"round\" class=\"feather feather-layers\">";
                        echo "<polygon points=\"12 2 2 7 12 12 22 7 12 2\"></polygon>";
                        echo "<polyline points=\"2 17 12 22 22 17\"></polyline>";
                        echo "<polyline points=\"2 12 12 17 22 12\"></polyline>";
                        echo "</svg>";
                        echo $row['ComputerName'];
                        echo "</a>";
                        echo "</li>";
                    }
                    ?>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <div style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"
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
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-calendar">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        This week
                    </button>
                </div>
            </div>

            <canvas class="my-4 chartjs-render-monitor" id="myChart" width="1240" height="523"
                    style="display: block; width: 1240px; height: 523px;"></canvas>

            <h2>daprogrammer-OptiPlex-9030-AIO</h2>
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
                    <tr>
                        <td>daprogrammer-OptiPlex-9030-AIO</td>
                        <td>16</td>
                        <td>19</td>
                        <td>54</td>
                        <td>92</td>
                        <td>97</td>
                        <td>56</td>
                        <td>97</td>
                        <td>66</td>
                        <td>31</td>
                        <td>85</td>
                        <td>da-programmer</td>
                        <td>2018-06-07</td>
                    </tr>
                    <tr>
                        <td>daprogrammer-OptiPlex-9030-AIO</td>
                        <td>21</td>
                        <td>22</td>
                        <td>99</td>
                        <td>51</td>
                        <td>35</td>
                        <td>13</td>
                        <td>67</td>
                        <td>78</td>
                        <td>24</td>
                        <td>2</td>
                        <td>da-programmer</td>
                        <td>2018-06-08</td>
                    </tr>
                    <tr>
                        <td>daprogrammer-OptiPlex-9030-AIO</td>
                        <td>74</td>
                        <td>78</td>
                        <td>56</td>
                        <td>85</td>
                        <td>72</td>
                        <td>83</td>
                        <td>95</td>
                        <td>18</td>
                        <td>33</td>
                        <td>66</td>
                        <td>da-programmer</td>
                        <td>2018-06-09</td>
                    </tr>
                    <tr>
                        <td>daprogrammer-OptiPlex-9030-AIO</td>
                        <td>15</td>
                        <td>78</td>
                        <td>60</td>
                        <td>1</td>
                        <td>60</td>
                        <td>13</td>
                        <td>30</td>
                        <td>96</td>
                        <td>72</td>
                        <td>7</td>
                        <td>da-programmer</td>
                        <td>2018-06-10</td>
                    </tr>
                    <tr>
                        <td>daprogrammer-OptiPlex-9030-AIO</td>
                        <td>72</td>
                        <td>94</td>
                        <td>41</td>
                        <td>68</td>
                        <td>77</td>
                        <td>18</td>
                        <td>36</td>
                        <td>35</td>
                        <td>81</td>
                        <td>13</td>
                        <td>da-programmer</td>
                        <td>2018-06-11</td>
                    </tr>
                    <tr>
                        <td>daprogrammer-OptiPlex-9030-AIO</td>
                        <td>79</td>
                        <td>51</td>
                        <td>62</td>
                        <td>12</td>
                        <td>12</td>
                        <td>12</td>
                        <td>32</td>
                        <td>41</td>
                        <td>72</td>
                        <td>26</td>
                        <td>da-programmer</td>
                        <td>2018-06-12</td>
                    </tr>
                    <tr>
                        <td>daprogrammer-OptiPlex-9030-AIO</td>
                        <td>14</td>
                        <td>66</td>
                        <td>25</td>
                        <td>98</td>
                        <td>99</td>
                        <td>51</td>
                        <td>34</td>
                        <td>64</td>
                        <td>99</td>
                        <td>66</td>
                        <td>da-programmer</td>
                        <td>2018-06-13</td>
                    </tr>
                    <tr>
                        <td>daprogrammer-OptiPlex-9030-AIO</td>
                        <td>46</td>
                        <td>0</td>
                        <td>33</td>
                        <td>13</td>
                        <td>57</td>
                        <td>45</td>
                        <td>33</td>
                        <td>30</td>
                        <td>1</td>
                        <td>44</td>
                        <td>da-programmer</td>
                        <td>2018-06-14</td>
                    </tr>
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
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
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
    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["2018-06-07", "2018-06-08", "2018-06-09", "2018-06-10", "2018-06-11", "2018-06-12", "2018-06-13", "2018-06-14"],
            datasets: [{

                data: [51.03, 42.14, 40.94, 46.23, 37.46, 40.3, 50.31, 45.36
                ],
                lineTension: 0,
                backgroundColor: 'transparent',
                borderColor: '#007bff',
                borderWidth: 4,
                pointBackgroundColor: '#007bff'
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