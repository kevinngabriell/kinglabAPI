<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = $_POST["request_id"];
    $job_title = $_POST['job_title'];
    $job_desc = $_POST['job_desc'];
    $criteria = $_POST['criteria'];
    $employee_id = $_POST['employee_id'];
    $hiring_status = 'HIRING001';

    $currentDateTime = new DateTime();
    
    $indonesiaTimeZone = new DateTimeZone('Asia/Jakarta');
    $currentDateTime->setTimezone($indonesiaTimeZone);

    $currentDateTimeString = $currentDateTime->format("Y-m-d H:i:s");
    
    $disableForeignKeyChecksQuery = "SET foreign_key_checks = 0";
    mysqli_query($connect, $disableForeignKeyChecksQuery);

    $insert_history_query = "INSERT IGNORE INTO job_ads 
        (id_job_ads, request_id, position_name, job_desc, criteria, hiring_status, insert_by, insert_dt) VALUES 
        (UUID(),, '$request_id', '$job_title', '$job_desc', '$criteria', '$hiring_status', '$employee_id', '$currentDateTimeString');";

    $update_log_query = "UPDATE new_employee_request SET last_status = 'NEW-STATUS-003', updated_by = '$employee_id', updated_dt = '$currentDateTimeString' WHERE id_new_employee_request = '$request_id';";

    $history_query = "INSERT IGNORE INTO new_employee_request_log 
        (id, new_request_id, action, action_by, action_dt) VALUES 
        (NULL, '$request_id', 'Lowongan pekerjaan telah dibuka', '$employee_id', '$currentDateTimeString');";

    if (mysqli_query($connect, $insert_history_query) && mysqli_query($connect, $update_log_query) && mysqli_query($connect, $history_query)) {
        http_response_code(200);
        echo json_encode(
            array(
                "StatusCode" => 200,
                'Status' => 'Success',
                "message" => "Success: Data inserted successfully"
            )
        );
    } else {
        http_response_code(400);
        echo json_encode(
            array(
                "StatusCode" => 400,
                'Status' => 'Error',
                "message" => "Error: Unable to update data - " . mysqli_error($connect)
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