<?php
include '../function.php';
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: DELETE');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == 'DELETE') {

    $deleteEmployee = deleteEmployee($_GET);
    echo $deleteEmployee;

} else {
    $data = [
        'status' => 405,
        'message' => $requestMethod . ' Method not allowed',
    ];
    header('HTTP/1.0 405 Method not allowed');
    echo json_encode($data);
}