<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];
    $company_name_1 = $_POST['company_name_1'];
    $company_position_1 = $_POST['company_position_1'];
    $company_address_1 = $_POST['company_address_1'];
    $company_type_1 = $_POST['company_type_1'];
    $company_start_1 = $_POST['company_start_1'];
    $company_end_1 = $_POST['company_end_1'];
    $company_leader_1 = $_POST['company_leader_1'];
    $company_salary_1 = $_POST['company_salary_1'];
    $company_jobdesc_1 = $_POST['company_jobdesc_1'];
    $company_leave_1 = $_POST['company_leave_1'];

    $company_name_2 = $_POST['company_name_2'];
    $company_position_2 = $_POST['company_position_2'];
    $company_address_2 = $_POST['company_address_2'];
    $company_type_2 = $_POST['company_type_2'];
    $company_start_2 = $_POST['company_start_2'];
    $company_end_2 = $_POST['company_end_2'];
    $company_leader_2 = $_POST['company_leader_2'];
    $company_salary_2 = $_POST['company_salary_2'];
    $company_jobdesc_2 = $_POST['company_jobdesc_2'];
    $company_leave_2 = $_POST['company_leave_2'];

    $company_name_3 = $_POST['company_name_3'];
    $company_position_3 = $_POST['company_position_3'];
    $company_address_3 = $_POST['company_address_3'];
    $company_type_3 = $_POST['company_type_3'];
    $company_start_3 = $_POST['company_start_3'];
    $company_end_3 = $_POST['company_end_3'];
    $company_leader_3 = $_POST['company_leader_3'];
    $company_salary_3 = $_POST['company_salary_3'];
    $company_jobdesc_3 = $_POST['company_jobdesc_3'];
    $company_leave_3 = $_POST['company_leave_3'];

    $query_one = "UPDATE employee_employement_history
SET 
    company_name = '$company_name_1', 
    company_position = '$company_position_1', 
    company_address = '$company_address_1', 
    company_type = '$company_type_1',
    company_start = '$company_start_1', 
    company_end = '$company_end_1', 
    company_leader = '$company_leader_1', 
    company_salary = '$company_salary_1', 
    company_jobdesc = '$company_jobdesc_1', 
    company_leave = '$company_leave_1'
WHERE id = '$id' AND `index` = 1;
";

$query_two = "UPDATE employee_employement_history
SET 
    company_name = '$company_name_2', 
    company_position = '$company_position_2', 
    company_address = '$company_address_2', 
    company_type = '$company_type_2',
    company_start = '$company_start_2', 
    company_end = '$company_end_2', 
    company_leader = '$company_leader_2', 
    company_salary = '$company_salary_2', 
    company_jobdesc = '$company_jobdesc_2', 
    company_leave = '$company_leave_2'
WHERE id = '$id' AND `index` = 2;";

$query_three = "UPDATE employee_employement_history
SET 
    company_name = '$company_name_3', 
    company_position = '$company_position_3', 
    company_address = '$company_address_3', 
    company_type = '$company_type_3',
    company_start = '$company_start_3', 
    company_end = '$company_end_3', 
    company_leader = '$company_leader_3', 
    company_salary = '$company_salary_3', 
    company_jobdesc = '$company_jobdesc_3', 
    company_leave = '$company_leave_3'
WHERE id = '$id' AND `index` = 3;";

    if (mysqli_query($connect, $query_one) && mysqli_query($connect, $query_two) && mysqli_query($connect, $query_three)) {
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