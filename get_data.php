<?php
include __DIR__ . '/../src/connect.php';
if (mysqli_connect_errno()) {
    echo "Connect failed: ";
    echo $mysqli_connect_error();
}
$sql = "
        DELETE FROM computers 
        WHERE 
        ComputerName = '" . mysqli_real_escape_string($cxn, $_POST['ComputerName']) . "' AND 
        users = '" . mysqli_real_escape_string($cxn, $_POST['users']) . "' AND 
        OrderDate = '" . mysqli_real_escape_string($cxn, $_POST['OrderDate']) . "';
";

mysqli_query($cxn, $sql);


$fields = ['ComputerName', 'usage_0', 'usage_10', 'usage_20', 'usage_30', 'usage_40', 'usage_50', 'usage_60', 'usage_70', 'usage_80', 'usage_90', 'users', 'OrderDate'];
$sql = composeInsertSql($fields, getValuesFromPost($fields));
#
mysqli_query($cxn, $sql);
