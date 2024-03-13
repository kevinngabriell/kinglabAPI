<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = $_POST["request_id"];
    $employee_id = $_POST['employee_id'];

    $currentDateTime = new DateTime();
    
    $indonesiaTimeZone = new DateTimeZone('Asia/Jakarta');
    $currentDateTime->setTimezone($indonesiaTimeZone);

    $currentDateTimeString = $currentDateTime->format("Y-m-d H:i:s");
    
    $disableForeignKeyChecksQuery = "SET foreign_key_checks = 0";
    mysqli_query($connect, $disableForeignKeyChecksQuery);

    $update_log_query = "UPDATE new_employee_request SET last_status = 'NEW-STATUS-006', updated_by = '$employee_id', updated_dt = '$currentDateTimeString' WHERE id_new_employee_request = '$request_id';";
    $insert_history_query = "INSERT IGNORE INTO new_employee_request_log 
        (id, new_request_id, action, action_by, action_dt) VALUES 
        (NULL, '$request_id', 'Permintaan karyawan baru anda telah ditolak oleh HRD', '$employee_id', '$currentDateTimeString');";

    if (mysqli_query($connect, $update_log_query) && mysqli_query($connect, $insert_history_query)) {
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