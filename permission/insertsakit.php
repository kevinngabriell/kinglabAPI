<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Display error message
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $permission_type = 'PER-TYPE-005';
    $last_permission_status = 'PER-STATUS-001';
    $jakartaTimezone = new DateTimeZone('Asia/Jakarta');
    $jakartaDatetime = new DateTime('now', $jakartaTimezone);
    $insertDatetime = $jakartaDatetime->format('Y-m-d H:i:s');
    $action = 'Input izin sakit telah berhasil dilakukan';
    $base64Image = $_POST['base64_image']; // Assuming 'base64_image' is the key for the base64 image string in your request
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $uuid = uniqid();

    // Decode the base64 image string into bytes
    $imageData = base64_decode($base64Image);

    // Prepare the insert query
    $insert_query = "INSERT INTO permission_log (
        id_permission, permission_type, employee_id, start_date, end_date, attachment, created_by, created_dt, last_permission_status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Prepare the statement
    $stmt = mysqli_prepare($connect, $insert_query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "sssssssss", $uuid, $permission_type, $id, $start_date, $end_date, $imageData, $id, $insertDatetime, $last_permission_status);

    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        // Your success response
        http_response_code(200);
        echo json_encode(
            array(
                "StatusCode" => 200,
                'Status' => 'Success',
                "message" => "Success: Data inserted successfully"
            )
        );
    } else {
        // Error handling
        http_response_code(404);
        echo json_encode(
            array(
                "StatusCode" => 400,
                'Status' => 'Error',
                "message" => "Error: Unable to insert data - " . mysqli_error($connect)
            )
        );
    }

    // Close statement
    mysqli_stmt_close($stmt);

} else {
    // Invalid method error
    http_response_code(404);
    echo json_encode(array(
        "StatusCode" => 404,
        'Status' => 'Error',
        "message" => "Error: Invalid method. Only POST requests are allowed."
    ));
}
?>
