<?php
include __DIR__ . '/../src/connect.php';
if (mysqli_connect_errno()) {
    echo "Connect failed: ";
    echo $mysqli_connect_error();
}

$question = $_GET['q'];

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

function getComputerNames($comp_name, $query)
{
    printf("
<li class=\"nav-item\">
    <a class=\"nav-link\" href=\".?id=%s&q=%s\">
        <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\"
             stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"
             class=\"feather feather-layers\">
            <polygon points=\"12 2 2 7 12 12 22 7 12 2\"></polygon>
            <polyline points=\"2 17 12 22 22 17\"></polyline>
            <polyline points=\"2 12 12 17 22 12\"></polyline>
        </svg>
        %s
    </a>
    <ul>", $comp_name, $query, $comp_name);
}

function getUserNames($comp_name, $user_name, $query)
{
    printf("
<li>
    <a class=\"nav-link\" href=\".?id=%s&user=%s&q=%s\">%s</a>
</li>\n", $comp_name, $user_name, $query, $user_name); // print out user names
}

setSideBarNav($cxn, $question);