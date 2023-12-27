<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    
    $family_1 = $_POST['family_1'];
    $family_name_1 = $_POST['family_name_1'];
    $family_address_1 = $_POST['family_address_1'];
    $family_pob_1 = $_POST['family_pob_1'];
    $family_dob_1 = $_POST['family_dob_1'];
    $family_edu_1 = $_POST['family_edu_1'];
    $family_job_1 = $_POST['family_job_1'];

    $family_2 = $_POST['family_2'];
    $family_name_2 = $_POST['family_name_2'];
    $family_address_2 = $_POST['family_address_2'];
    $family_pob_2 = $_POST['family_pob_2'];
    $family_dob_2 = $_POST['family_dob_2'];
    $family_edu_2 = $_POST['family_edu_2'];
    $family_job_2 = $_POST['family_job_2'];

    $family_3 = $_POST['family_3'];
    $family_name_3 = $_POST['family_name_3'];
    $family_address_3 = $_POST['family_address_3'];
    $family_pob_3 = $_POST['family_pob_3'];
    $family_dob_3 = $_POST['family_dob_3'];
    $family_edu_3 = $_POST['family_edu_3'];
    $family_job_3 = $_POST['family_job_3'];

    $family_4 = $_POST['family_4'];
    $family_name_4 = $_POST['family_name_4'];
    $family_address_4 = $_POST['family_address_4'];
    $family_pob_4 = $_POST['family_pob_4'];
    $family_dob_4 = $_POST['family_dob_4'];
    $family_edu_4 = $_POST['family_edu_4'];
    $family_job_4 = $_POST['family_job_4'];

    $family_5 = $_POST['family_5'];
    $family_name_5 = $_POST['family_name_5'];
    $family_address_5 = $_POST['family_address_5'];
    $family_pob_5 = $_POST['family_pob_5'];
    $family_dob_5 = $_POST['family_dob_5'];
    $family_edu_5 = $_POST['family_edu_5'];
    $family_job_5 = $_POST['family_job_5'];

    $query = "INSERT ignore INTO employee_family_background (id, family_type_1, family_name_1, family_address_1, family_pob_1, family_dob_1, family_last_edu_1, family_job_1, family_type_2, family_name_2, family_address_2, family_pob_2, family_dob_2, family_last_edu_2, family_job_2, family_type_3, family_name_3, family_address_3, family_pob_3, family_dob_3, family_last_edu_3, family_job_3, family_type_4, family_name_4, family_address_4, family_pob_4, family_dob_4, family_last_edu_4, family_job_4, family_type_5, family_name_5, family_address_5, family_pob_5, family_dob_5, family_last_edu_5, family_job_5) VALUES ('$id', '$family_1', '$family_name_1', '$family_address_1', '$family_pob_1', '$family_dob_1', '$family_edu_1', '$family_job_1', '$family_2', '$family_name_2', '$family_address_2', '$family_pob_2', '$family_dob_2', '$family_edu_2', '$family_job_2', '$family_3', '$family_name_3', '$family_address_3', '$family_pob_3', '$family_dob_3', '$family_edu_3', '$family_job_3', '$family_4', '$family_name_4', '$family_address_4', '$family_pob_4', '$family_dob_4', '$family_edu_4', '$family_job_4', '$family_5', '$family_name_5', '$family_address_5', '$family_pob_5', '$family_dob_5', '$family_edu_5', '$family_job_5');";

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