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