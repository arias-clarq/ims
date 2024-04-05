<?php
include '../dbcon.php';

$user = $_POST['username'];
$pass = $_POST['password'];
$role = $_POST['role'];

$sql = "INSERT INTO `tbl_employee_account`(`username`, `password`, `login_role`) VALUES ('{$user}','{$pass}','{$role}')";
$result = $conn->query($sql);
$id = $conn->insert_id;

if($result === TRUE){
    $sql1 = "UPDATE `tbl_employee_account` SET `employee_info_id`='{$id}', `job_id`= '{$id}' WHERE `account_id` = '{$id}' ";
    $result1 = $conn->query($sql1);

    if($result1 !== TRUE){
        echo 'Error2 adding employee: '.$conn->error;
    }

    $sql2 = "INSERT INTO `tbl_employee_info`(`employee_info_id`, `spouse_id`, `bill_id`) VALUES ('{$id}','{$id}','{$id}')";
    $result2 = $conn->query($sql2);

    if($result2 !== TRUE){
        echo 'Error2 adding employee: '.$conn->error;
    }

    $sql3 = "INSERT INTO `tbl_job`(`job_id`) VALUES ('{$id}')";
    $result3 = $conn->query($sql3);

    if($result3 !== TRUE){
        echo 'Error2 adding employee: '.$conn->error;
    }

    $sql4 = "INSERT INTO `tbl_spouse`(`spouse_id`) VALUES ('{$id}')";
    $result4 = $conn->query($sql4);

    if($result4 !== TRUE){
        echo 'Error2 adding employee: '.$conn->error;
    }

    $sql5 = "INSERT INTO `tbl_bill`(`bill_id`) VALUES ('{$id}')";
    $result5 = $conn->query($sql5);

    if($result5 !== TRUE){
        echo 'Error2 adding employee: '.$conn->error;
    }

    header('location: ../../index.php');
}
else{
    echo 'Error1 adding employee: '.$conn->error;
}