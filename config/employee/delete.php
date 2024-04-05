<?php
include '../dbcon.php';
$id = $_POST['id'];

$sql = "DELETE FROM `tbl_employee_account` WHERE `account_id` = '{$id}'";
$result = $conn->query($sql);
if($result !== TRUE){
    echo 'Error: '.$conn->error;
}

$sql1 = "DELETE FROM `tbl_employee_info` WHERE `employee_info_id` = '{$id}'";
$result1 = $conn->query($sql1);
if($result1 !== TRUE){
    echo 'Error: '.$conn->error;
}

$sql2 = "DELETE FROM `tbl_job` WHERE `job_id` = '{$id}'";
$result2 = $conn->query($sql2);
if($result2 !== TRUE){
    echo 'Error: '.$conn->error;
}

$sql3 = "DELETE FROM `tbl_spouse` WHERE `spouse_id` = '{$id}'";
$result3 = $conn->query($sql3);
if($result3 !== TRUE){
    echo 'Error: '.$conn->error;
}

$sql4 = "DELETE FROM `tbl_bill` WHERE `bill_id` = '{$id}'";
$result4 = $conn->query($sql4);
if($result4 !== TRUE){
    echo 'Error: '.$conn->error;
}

header('location: ../../index.php');