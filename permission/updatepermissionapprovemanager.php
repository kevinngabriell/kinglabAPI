<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPermission = $_POST["id_permission"];
    $employee_id = $_POST['employee_id'];

    $currentDateTime = new DateTime();

    $indonesiaTimeZone = new DateTimeZone('Asia/Jakarta');
    $currentDateTime->setTimezone($indonesiaTimeZone);

    $currentDateTimeString = $currentDateTime->format("Y-m-d H:i:s");
    
    $disableForeignKeyChecksQuery = "SET foreign_key_checks = 0";
    mysqli_query($connect, $disableForeignKeyChecksQuery);

    $update_log_query = "UPDATE permission_log SET last_permission_status = 'PER-STATUS-002', update_by = '$employee_id', update_dt = '$currentDateTimeString' WHERE id_permission = '$idPermission'";
    $insert_history_query = "INSERT IGNORE INTO permission_history (id, permission_id, action, action_by, action_dt) VALUES (NULL, '$idPermission', 'Izin telah disetujui oleh manajer dan menunggu persetujuan HRD', '$employee_id', '$currentDateTimeString');";

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