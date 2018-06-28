<?php
include __DIR__ . '/../../src/connect.php';
if (mysqli_connect_errno()) {
    echo "Connect failed: ";
    echo $mysqli_connect_error();
}

$stmtQuery1 = mysqli_query($cxn, "SELECT DISTINCT ComputerName FROM computers");
while ($comp_name = mysqli_fetch_array($stmtQuery1)) {
    if ($comp_name[0] != null) {
        printf("%s\n", $comp_name[0]);

        $stmtQuery2 = mysqli_query($cxn, "SELECT DISTINCT users FROM computers WHERE ComputerName='$comp_name[0]'");
        while ($user_name = mysqli_fetch_array($stmtQuery2)) {
            printf("\t%s\n", $user_name[0]);
        }
        printf("\n");

    }
}