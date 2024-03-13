<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $permission_type = 'PER-TYPE-004';
    $overtime_date = $_POST['overtime_date'];
    $overtime_start = $_POST['overtime_start'];
    $overtime_end = $_POST['overtime_end'];
    $overtime_reason = $_POST['overtime_reason'];
    $last_permission_status = 'PER-STATUS-001';
    $date_now = $_POST['date_now'];
    $action = 'Input izin lembur telah berhasil dilakukan';

    $query = "INSERT IGNORE INTO permission_log 
        (id_permission, permission_type, `employee_id`, `lembur_date`,`lembur_start`, `lembur_end`, `lembur_keperluan`, `last_permission_status`, `created_by`, `created_dt`) 
        VALUES (NULL, '$permission_type', '$id', '$overtime_date', '$overtime_start', '$overtime_end', '$overtime_reason', '$last_permission_status', '$id', '$date_now',);";
    
    if(mysqli_query($connect, $query)) {
        $last_permission_id_query = "SELECT id_permission FROM permission_log ORDER BY id_permission DESC LIMIT 1;";
        $result_last_permission_id = $connect->query($last_permission_id_query);

        $row = $result_last_permission_id->fetch_assoc();
        $last_permission_id = $row["id_permission"];

        $query_history = "INSERT IGNORE INTO permission_history 
        (id, permission_id, action, action_by, action_dt) VALUES 
        (NULL, '$last_permission_id', '$action', '$id', '$date_now');";

        if(mysqli_query($connect, $query_history)) {
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
                    "StatusCode" => 400,
                    'Status' => 'Error',
                    "message" => "Error: Unable to insert data - " . mysqli_error($connect)
                )
            );
        }
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