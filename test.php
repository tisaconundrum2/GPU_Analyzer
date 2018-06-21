<?php
include __DIR__ . '/../src/connect.php';
if (mysqli_connect_errno()) {
    echo "Connect failed: ";
    echo $mysqli_connect_error();
}

$query = "SELECT DISTINCT users FROM computers WHERE ComputerName='EN4073254W'";
$stmtQuery = mysqli_query($cxn, $query);
while ($user_name = mysqli_fetch_array($stmtQuery)) {
    printf("<li><a href='%s'>%s</a>\n", $user_name[0], $user_name[0]);
}