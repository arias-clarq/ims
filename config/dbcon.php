<?php
    $username = "root";
    $password = "";
    $dbname= "db_ims";
    $servername = "localhost";
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if($conn->connect_error === true) {
        die("Error". $conn->connect_error);
    } 