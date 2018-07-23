<?php

function table_td($string)
{
    echo "<td>" . $string . "</td>";
}

function queryComputerUsages($cxn, $user, $id, $date, $days = 5)
{
    $p_date = date("Y-m-d", strtotime("+$days day", strtotime($date)));
    $full_query = "SELECT * FROM computers WHERE ComputerName='$id' ";
    if ($user) {
        $full_query .= "AND users='$user' ";
    }

    if ($date) {
        $full_query .= "AND OrderDate BETWEEN '$date' AND '$p_date' ";
    }
    $full_query .= "ORDER BY `computers`.`OrderDate` ASC";
    return mysqli_query($cxn, $full_query);
}

function setSideBarNav($cxn, $query)
{
    // For the side navbar, shows all the available computers
    if ($query != null) {
        $stmtQuery1 = mysqli_query($cxn, "SELECT DISTINCT ComputerName FROM computers WHERE ComputerName LIKE '%$query%'");
    } else {
        $stmtQuery1 = mysqli_query($cxn, "SELECT DISTINCT ComputerName FROM computers");
    }
    while ($comp_name = mysqli_fetch_array($stmtQuery1)) {
        if ($comp_name[0] != null) {
            getComputerNames($comp_name[0], $query);

            $stmtQuery2 = mysqli_query($cxn, "SELECT DISTINCT users FROM computers WHERE ComputerName='$comp_name[0]'");
            while ($user_name = mysqli_fetch_array($stmtQuery2)) {
                getUserNames($comp_name[0], $user_name[0], $query);
            }
            printf("</ul>\n");
        }
    }
    printf("</li>");
}

function getComputerNames($comp_name, $date, $query)
{
    printf("
<li class=\"nav-item\">
    <a class=\"nav-link\" href=\".?id=%s&q=%s&date=%s\">
        <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\"
             stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"
             class=\"feather feather-layers\">
            <polygon points=\"12 2 2 7 12 12 22 7 12 2\"></polygon>
            <polyline points=\"2 17 12 22 22 17\"></polyline>
            <polyline points=\"2 12 12 17 22 12\"></polyline>
        </svg>
        %s
    </a>
    <ul>", $comp_name, $query, $date, $comp_name);
}

function getUserNames($comp_name, $user_name, $query)
{
    printf("
<li>
    <a class=\"nav-link\" href=\".?id=%s&user=%s&q=%s\">%s</a>
</li>\n", $comp_name, $user_name, $query, $user_name); // print out user names
}

function runHead()
{
    printf("
<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\">
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
    <meta name=\"description\"
          content=\"GPUtilization. A website dedicated to helping IT gather information on GPU utilizations across the network\">
    <meta name=\"author\" content=\"Nicholas Finch\">
    <link rel=\"icon\" href=\"https://getbootstrap.com/favicon.ico\">

    <title>Dashboard for GPUtil</title>

    <!-- Bootstrap core CSS -->
    <link rel=\"stylesheet\" href=\"css/bootstrap.css\">
    <!-- Custom styles for this template -->
    <link href=\"css/dashboard.css\" rel=\"stylesheet\">
    <style type=\"text/css\">/* Chart.js */
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
");
}

function runTopSticky()
{
    printf("
<form action=\"\">
    <nav class=\"navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0\">
        <a class=\"navbar-brand col-sm-3 col-md-2 mr-0\" href=\"index.php\">ASU - GPU utilizations</a>
        <input class=\"form-control form-control-dark w-100\" placeholder=\"Search\" aria-label=\"Search\" type=\"text\" name=\"q\">
        <!--    Sign in button. Not applicable quite yet    -->
        <!--        <ul class=\"navbar-nav px-3\">-->
        <!--            <li class=\"nav-item text-nowrap\">-->
        <!--                <a class=\"nav-link\" href=\"#\">Sign out</a>-->
        <!--            </li>-->
        <!--        </ul>-->
    </nav>
</form>
");
}

function runSideSticky()
{
    printf("
<nav class=\"col-md-2 d-none d-md-block bg-light sidebar\">
    <div class=\"sidebar-sticky\">
        <ul class=\"nav flex-column\" id=\"sidebar\">
        </ul>
    </div>
</nav>    
");
}