<?php
include '../../config/dbcon.php';
function getEmployeeList()
{
    global $conn;
    $sql = 'SELECT * FROM `tbl_employee_account`';
    $result = $conn->query($sql);

    if ($result) {

        if ($result->num_rows <= 0) {
            $data = [
                'status' => 404,
                'message' => 'No Employee Found',
            ];
            header('HTTP/1.0 404 No Employee Found');
            return json_encode($data);
        }

        while ($row = $result->fetch_assoc()) {
            $employeeList = [
                "account_id" => $row['account_id'],
                "username" => $row['username'],
                "password" => $row['password'],
                "login_role" => $row['login_role']
            ];
            $sql1 = "SELECT * FROM `tbl_employee_info` WHERE `employee_info_id` = '{$row['account_id']}'";
            $result1 = $conn->query($sql1);
            while ($row1 = $result1->fetch_assoc()) {
                $employee_info = [
                    "firstname" => $row1['firstname'],
                    "middlename" => $row1['middlename'],
                    "lastname" => $row1['lastname'],
                    "birthdate" => $row1['birthdate'],
                    "gender" => $row1['gender'],
                    "age" => $row1['age'],
                    "marital_status" => $row1['marital_status'],
                    "id_profile" => $row1['id_profile'],
                    "email" => $row1['email'],
                    "phone_num" => $row1['phone_num'],
                    "province" => $row1['province'],
                    "zip" => $row1['zip'],
                    "elem" => $row1['elem'],
                    "jhs" => $row1['jhs'],
                    "shs" => $row1['shs'],
                    "college" => $row1['college']
                ];
            }
            $sql2 = "SELECT * FROM `tbl_job` WHERE `job_id` = '{$row['account_id']}'";
            $result2 = $conn->query($sql2);
            while ($row2 = $result2->fetch_assoc()) {
                $employee_job = [
                    "job_title" => $row2['job_title'],
                    "employement_num" => $row2['employement_num'],
                    "department_number" => $row2['department_number'],
                    "hire_date" => $row2['hire_date'],
                    "employee_status" => $row2['employee_status'],
                    "job_value" => $row2['job_value'],
                    "dep_value" => $row2['dep_value'],
                    "stat_value" => $row2['stat_value'],
                    "salary" => $row2['salary']
                ];
            }
            $sql3 = "SELECT * FROM `tbl_bill` WHERE `bill_id` = '{$row['account_id']}'";
            $result3 = $conn->query($sql3);
            while ($row3 = $result3->fetch_assoc()) {
                $employee_bill = [
                    "sss" => $row3['sss'],
                    "pagibig" => $row3['pagibig'],
                    "phil" => $row3['phil']
                ];
            }
            $sql4 = "SELECT * FROM `tbl_spouse` WHERE `spouse_id` = '{$row['account_id']}'";
            $result4 = $conn->query($sql4);
            while ($row4 = $result4->fetch_assoc()) {
                $employee_spouse = [
                    "spouse_name" => $row4['spouse_name'],
                    "relationship" => $row4['relationship'],
                    "number" => $row4['number'],
                    "email" => $row4['email'],
                    "brgy" => $row4['brgy'],
                    "municipality" => $row4['municipality']
                ];
            }
            // Append the $employee_info array to the $employeeList array
            $employeeList["employee_info"] = $employee_info;
            // Append the $employee_job array to the $employeeList array
            $employeeList["employee_job"] = $employee_job;
            // Append the $employee_bill array to the $employeeList array
            $employeeList["employee_bill"] = $employee_bill;
            // Append the $employee_spouse array to the $employeeList array
            $employeeList["employee_spouse"] = $employee_spouse;

            // Append the $employee array to the $employees array
            $data[] = $employeeList;
        }
        $data = [
            'status' => 200,
            'message' => 'Employee List Fetch Success',
            'data' => $data
        ];
        header('HTTP/1.0 200 Employee List Fetch Success');
        return json_encode($data);

    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header('HTTP/1.0 500 Internal Server Error');
        return json_encode($data);
    }
}
function error422($message)
{
    $data = [
        'status' => 422,
        'message' => $message,
    ];
    header('HTTP/1.0 422 Invalid Entity');
    echo json_encode($data);
    exit();
}
function storedEmployee($input)
{
    global $conn;

    $username = $conn->real_escape_string($input['username']);
    $password = $conn->real_escape_string($input['password']);
    $login_role = $conn->real_escape_string($input['login_role']);

    if (empty(trim($username))) {
        return error422('Enter Username');
    }
    if (empty(trim($password))) {
        return error422('Enter password');
    }
    if (empty(trim($login_role))) {
        return error422('Enter login_role');
    }

    $sql = "INSERT INTO `tbl_employee_account`(`username`, `password`, `login_role`) VALUES ('{$username}','{$password}','{$login_role}')";
    $result = $conn->query($sql);
    $id = $conn->insert_id;

    if ($result) {
        $sql1 = "UPDATE `tbl_employee_account` SET `employee_info_id`='{$id}', `job_id`= '{$id}' WHERE `account_id` = '{$id}' ";
        $result1 = $conn->query($sql1);

        if ($result1 !== TRUE) {
            return error422('Error adding employee account');
        }

        $sql2 = "INSERT INTO `tbl_employee_info`(`employee_info_id`, `spouse_id`, `bill_id`) VALUES ('{$id}','{$id}','{$id}')";
        $result2 = $conn->query($sql2);

        if ($result2 !== TRUE) {
            return error422('Error adding employee info');
        }

        $sql3 = "INSERT INTO `tbl_job`(`job_id`) VALUES ('{$id}')";
        $result3 = $conn->query($sql3);

        if ($result3 !== TRUE) {
            return error422('Error adding employee job');
        }

        $sql4 = "INSERT INTO `tbl_spouse`(`spouse_id`) VALUES ('{$id}')";
        $result4 = $conn->query($sql4);

        if ($result4 !== TRUE) {
            return error422('Error adding employee spouse');
        }

        $sql5 = "INSERT INTO `tbl_bill`(`bill_id`) VALUES ('{$id}')";
        $result5 = $conn->query($sql5);

        if ($result5 !== TRUE) {
            return error422('Error adding employee bill');
        }

        $data = [
            'status' => 201,
            'message' => 'Employee Created Successful',
        ];
        header('HTTP/1.0 201 created');
        return json_encode($data);
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header('HTTP/1.0 500 Internal Server Error');
        return json_encode($data);
    }
}

function getEmployee($account_id){
    global $conn;

    if ($account_id == null) {
        return error422('Enter Employee Id');
    }

    $id = $conn->real_escape_string($account_id);
    $sql = "SELECT * FROM `tbl_employee_account` WHERE `account_id` = $id";
    $result = $conn->query($sql);

    if($result){
        if ($result->num_rows <= 0) {
            $data = [
                'status' => 404,
                'message' => 'No Employee Found',
            ];
            header('HTTP/1.0 404 No Employee Found');
            return json_encode($data);
        }

        while ($row = $result->fetch_assoc()) {
            $employeeList = [
                "account_id" => $row['account_id'],
                "username" => $row['username'],
                "password" => $row['password'],
                "login_role" => $row['login_role']
            ];
            $sql1 = "SELECT * FROM `tbl_employee_info` WHERE `employee_info_id` = '{$row['account_id']}'";
            $result1 = $conn->query($sql1);
            while ($row1 = $result1->fetch_assoc()) {
                $employee_info = [
                    "firstname" => $row1['firstname'],
                    "middlename" => $row1['middlename'],
                    "lastname" => $row1['lastname'],
                    "birthdate" => $row1['birthdate'],
                    "gender" => $row1['gender'],
                    "age" => $row1['age'],
                    "marital_status" => $row1['marital_status'],
                    "id_profile" => $row1['id_profile'],
                    "email" => $row1['email'],
                    "phone_num" => $row1['phone_num'],
                    "province" => $row1['province'],
                    "zip" => $row1['zip'],
                    "elem" => $row1['elem'],
                    "jhs" => $row1['jhs'],
                    "shs" => $row1['shs'],
                    "college" => $row1['college']
                ];
            }
            $sql2 = "SELECT * FROM `tbl_job` WHERE `job_id` = '{$row['account_id']}'";
            $result2 = $conn->query($sql2);
            while ($row2 = $result2->fetch_assoc()) {
                $employee_job = [
                    "job_title" => $row2['job_title'],
                    "employement_num" => $row2['employement_num'],
                    "department_number" => $row2['department_number'],
                    "hire_date" => $row2['hire_date'],
                    "employee_status" => $row2['employee_status'],
                    "job_value" => $row2['job_value'],
                    "dep_value" => $row2['dep_value'],
                    "stat_value" => $row2['stat_value'],
                    "salary" => $row2['salary']
                ];
            }
            $sql3 = "SELECT * FROM `tbl_bill` WHERE `bill_id` = '{$row['account_id']}'";
            $result3 = $conn->query($sql3);
            while ($row3 = $result3->fetch_assoc()) {
                $employee_bill = [
                    "sss" => $row3['sss'],
                    "pagibig" => $row3['pagibig'],
                    "phil" => $row3['phil']
                ];
            }
            $sql4 = "SELECT * FROM `tbl_spouse` WHERE `spouse_id` = '{$row['account_id']}'";
            $result4 = $conn->query($sql4);
            while ($row4 = $result4->fetch_assoc()) {
                $employee_spouse = [
                    "spouse_name" => $row4['spouse_name'],
                    "relationship" => $row4['relationship'],
                    "number" => $row4['number'],
                    "email" => $row4['email'],
                    "brgy" => $row4['brgy'],
                    "municipality" => $row4['municipality']
                ];
            }
            // Append the $employee_info array to the $employeeList array
            $employeeList["employee_info"] = $employee_info;
            // Append the $employee_job array to the $employeeList array
            $employeeList["employee_job"] = $employee_job;
            // Append the $employee_bill array to the $employeeList array
            $employeeList["employee_bill"] = $employee_bill;
            // Append the $employee_spouse array to the $employeeList array
            $employeeList["employee_spouse"] = $employee_spouse;

            // Append the $employee array to the $employees array
            $data[] = $employeeList;
        }

        $data = [
            'status' => 200,
            'message' => 'Employee Fetch Success',
            'data' => $data
        ];
        header('HTTP/1.0 200 Employee Fetch Success');
        return json_encode($data);

    }else{
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header('HTTP/1.0 500 Internal Server Error');
        return json_encode($data);
    }

}

function updateEmployee($input, $params){
    global $conn;

    if(!isset($params['account_id'])){
        return error422('account id not found in the url');
    }elseif($params['account_id'] == null){
        return error422('enter employee id');
    }

    $id = $conn->real_escape_string($params['account_id']);
    $username = $conn->real_escape_string($input['username']);
    $password = $conn->real_escape_string($input['password']);
    $login_role = $conn->real_escape_string($input['login_role']);

    if (empty(trim($username))) {
        return error422('Enter Username');
    }
    if (empty(trim($password))) {
        return error422('Enter password');
    }
    if (empty(trim($login_role))) {
        return error422('Enter login_role');
    }

    $sql = "UPDATE `tbl_employee_account` SET `username`='{$username}',`password`='{$password}',`login_role`='{$login_role}' WHERE `account_id` = '{$id}'";
    $result = $conn->query($sql);
    $id = $conn->insert_id;

    if ($result) {

        $data = [
            'status' => 200,
            'message' => 'Employee Updated Successful',
        ];
        header('HTTP/1.0 200 Success');
        return json_encode($data);
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header('HTTP/1.0 500 Internal Server Error');
        return json_encode($data);
    }
}

function deleteEmployee($params){
    global $conn;

    if(!isset($params['account_id'])){
        return error422('account id not found in the url');
    } elseif($params['account_id'] == null){
        return error422('enter employee id');
    }

    $account_id = $conn->real_escape_string($params['account_id']);

    // Array to hold the status of each deletion
    $deletionStatus = [];

    // Define SQL queries for deletion
    $sqlQueries = [
        "DELETE FROM `tbl_employee_account` WHERE `account_id` = $account_id",
        "DELETE FROM `tbl_employee_info` WHERE `employee_info_id` = $account_id",
        "DELETE FROM `tbl_job` WHERE `job_id` = $account_id",
        "DELETE FROM `tbl_spouse` WHERE `spouse_id` = $account_id",
        "DELETE FROM `tbl_bill` WHERE `bill_id` = $account_id"
    ];

    // Count of affected rows
    $affectedRows = 0;

    // Execute each SQL query and count the affected rows
    foreach ($sqlQueries as $sqlQuery) {
        $result = $conn->query($sqlQuery);
        if (!$result) {
            // If deletion fails, add error message to status array
            $deletionStatus[] = 'Failed to delete: ' . $conn->error;
        } else {
            $affectedRows += $conn->affected_rows;
        }
    }

    // If no rows were affected, return error response
    if ($affectedRows === 0) {
        $data = [
            'status' => 404,
            'message' => 'No employee found with the specified account_id'
        ];
        header('HTTP/1.0 404 not found');
        return json_encode($data);
    }

    // If any deletion failed, return error response
    if (!empty($deletionStatus)) {
        $data = [
            'status' => 500,
            'message' => implode("\n", $deletionStatus)
        ];
        header('HTTP/1.0 500 Internal Server Error');
        return json_encode($data);
    }

    // If all deletions were successful, return success response
    $data = [
        'status' => 200,
        'message' => 'Employee Deleted Successfully',
    ];
    header('HTTP/1.0 200 Deleted');
    return json_encode($data);
}

