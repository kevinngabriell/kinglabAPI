<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $permission_type = 'PER-TYPE-002';
    $permission_date = $_POST['permission_date'];
    $permission_reason = $_POST['permission_reason'];
    $permission_time = $_POST['permission_time'];
    $last_permission_status = 'PER-STATUS-001';
    $date_now = $_POST['date_now'];
    $action = 'Input izin datang telat telah berhasil dilakukan';

    $query = "INSERT IGNORE INTO permission_log 
        (id_permission, permission_type, `employee_id`, `permission_date`, `permission_reason`, `permission_time`, `cuti_phone`, `start_date`, `end_date`, `pengganti_cuti`, `last_permission_status`, `reject_reason`, `created_by`, `created_dt`, `update_by`, `update_dt`) 
        VALUES (UUID(), '$permission_type', '$id', '$permission_date', '$permission_reason', '$permission_time', NULL, NULL, NULL, NULL, '$last_permission_status', NULL, '$id', '$date_now', '$id', '$date_now');";
    
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