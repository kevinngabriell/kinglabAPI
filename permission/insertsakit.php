<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $permission_type = 'PER-TYPE-005';
    $last_permission_status = 'PER-STATUS-001';
    $jakartaTimezone = new DateTimeZone('Asia/Jakarta');
    $jakartaDatetime = new DateTime('now', $jakartaTimezone);
    $insertDatetime = $jakartaDatetime->format('Y-m-d H:i:s');
    $action = 'Input izin sakit telah berhasil dilakukan';
    $attachment = base64_decode($_POST['attachment']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $insert_query = "INSERT INTO permission_log (id_permission, permission_type, employee_id, start_date, end_date, attachment, created_by, created_dt) VALUES (UUID(), '$permission_type', '$id', '$start_date', '$end_date', '$attachment', '$id', '$insertDatetime')";

    if(mysqli_query($connect, $insert_query)){
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
    } else {

    }
    
} else {
    http_response_code(404);
    echo json_encode(array(
        "StatusCode" => 404,
        'Status' => 'Error',
        "message" => "Error: Invalid method. Only POST requests are allowed."
    ));
}
?>