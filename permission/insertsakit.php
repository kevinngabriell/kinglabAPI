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
    $action = 'Input izin pulang awal telah berhasil dilakukan';
    $attachment = base64_decode($_POST['attachment']);

    $query = "INSERT INTO `permission_log` 
    (`permission_type`, `employee_id`, `attachment`, `created_by`, `created_dt`) 
    VALUES ('$permission_type', '$id', ?, '$id', '$insertDatetime');";

    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, 's', $attachment);

    if (mysqli_stmt_execute($stmt)) {
        http_response_code(200);
        echo json_encode(array(
            "StatusCode" => 200,
            'Status' => 'Success',
            "message" => "Success: Data inserted successfully"
        ));
    } else {
        http_response_code(400);
        echo json_encode(array(
            "StatusCode" => 400,
            'Status' => 'Error',
            "message" => "Error: Unable to insert data - " . mysqli_error($connect)
        ));
    }
    mysqli_stmt_close($stmt);
    
} else {
    http_response_code(404);
    echo json_encode(array(
        "StatusCode" => 404,
        'Status' => 'Error',
        "message" => "Error: Invalid method. Only POST requests are allowed."
    ));
}
?>