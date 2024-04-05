<?php
include '../function.php';
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: GET');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if($requestMethod == 'GET'){
    if(isset($_GET['account_id'])){
        $employee = getEmployee($_GET['account_id']);
        echo $employee;
    }else{
        $employeeList = getEmployeeList();
        echo $employeeList;
    }
    
    
}else{
    $data = [
        'status' => 405,
        'message' => $requestMethod. ' Method not allowed',
    ];
    header('HTTP/1.0 405 Method not allowed');
    echo json_encode($data);
}