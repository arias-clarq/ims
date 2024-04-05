<?php
// error_reporting(0);
include '../function.php';
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: PUT');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if($requestMethod == 'PUT'){
    $inputData = json_decode(file_get_contents("php://input"), true);
    $updateEmployee = updateEmployee($inputData, $_GET);
    echo $updateEmployee;
}else{
    $data = [
        'status' => 405,
        'message' => $requestMethod. ' Method not allowed',
    ];
    header('HTTP/1.0 405 Method not allowed');
    echo json_encode($data);
}