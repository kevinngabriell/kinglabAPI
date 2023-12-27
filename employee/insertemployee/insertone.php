<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = $_POST['employee_id'];
    $employee_name = $_POST['employee_name'];
    $department_id = $_POST['department_id'];
    $position_id = $_POST['position_id'];
    $company_id = $_POST['company_id'];
    $gender = $_POST['gender'];
    $employee_pob = $_POST['employee_pob'];
    $employee_dob = $_POST['employee_dob'];
    $employee_nationality = $_POST['employee_nationality'];
    $employee_identity = $_POST['employee_identity'];
    $employee_jamsostek = $_POST['employee_jamsostek'];
    $employee_status = $_POST['employee_status'];
    $employee_religion = $_POST['employee_religion'];

    $query = "INSERT IGNORE INTO employee (employee_id, employee_name, employee_status_id, department_id, position_id, company_id, gender, employee_pob, employee_dob, employee_nationality, employee_identity, employee_jamsostek, employee_status, employee_religion) 
              VALUES ('$employee_id', '$employee_name', 'ES-HR-001', '$department_id', '$position_id', '$company_id', '$gender', '$employee_pob', '$employee_dob', '$employee_nationality', '$employee_identity', '$employee_jamsostek', '$employee_status', '$employee_religion')";

    if (mysqli_query($connect, $query)) {
        http_response_code(200);
        echo json_encode(
            array(
                "StatusCode" => 200,
                'Status' => 'Success',
                "message" => "Success: Data inserted successfully"
            )
        );
    } else {
        http_response_code(404);
        echo json_encode(
            array(
                "StatusCode" => 404,
                'Status' => 'Error',
                "message" => "Error: Unable to insert data - " . mysqli_error($connect)
            )
        );
    }
} else {
    http_response_code(404);
    echo json_encode(
        array(
            "StatusCode" => 404,
            'Status' => 'Error',
            "message" => "Error: Invalid method. Only POST requests are allowed."
        )
    );
}

?>