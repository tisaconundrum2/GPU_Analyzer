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
        users = '".mysqli_real_escape_string($cxn, $_POST['users'])."' AND 
        OrderDate = '".mysqli_real_escape_string($cxn, $_POST['OrderDate'])."';
";

mysqli_query($cxn, $sql);

$sql = "
        INSERT INTO `computers` (`ComputerName`, `usage_0`, `usage_10`, `usage_20`, `usage_30`, `usage_40`, `usage_50`, `usage_60`, `usage_70`, `usage_80`, `usage_90`, `users`, `OrderDate`)
        VALUES (
        '" . mysqli_real_escape_string($cxn, $_POST['ComputerName']) . "',
        '".mysqli_real_escape_string($cxn, $_POST['usage_0'])."',
        '".mysqli_real_escape_string($cxn, $_POST['usage_10'])."',
        '".mysqli_real_escape_string($cxn, $_POST['usage_20'])."',
        '".mysqli_real_escape_string($cxn, $_POST['usage_30'])."',
        '".mysqli_real_escape_string($cxn, $_POST['usage_40'])."',
        '".mysqli_real_escape_string($cxn, $_POST['usage_50'])."',
        '".mysqli_real_escape_string($cxn, $_POST['usage_60'])."',
        '".mysqli_real_escape_string($cxn, $_POST['usage_70'])."',
        '".mysqli_real_escape_string($cxn, $_POST['usage_80'])."',
        '".mysqli_real_escape_string($cxn, $_POST['usage_90'])."',
        '".mysqli_real_escape_string($cxn, $_POST['users'])."',
        '".mysqli_real_escape_string($cxn, $_POST['OrderDate'])."');
";

mysqli_query($cxn, $sql);
