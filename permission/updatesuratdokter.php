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
    $base64Image = $_POST['base64_image']; // Assuming 'base64_image' is the key for the base64 image string in your request
    $permission_id = $_POST['permission_id']; // Assuming 'permission_id' is the key for the permission ID in your request

    // Decode the base64 image string into bytes
    $imageData = base64_decode($base64Image);

    // Prepare the update query for attachment
    $update_query = "UPDATE permission_log SET
        attachment = ?
        WHERE id_permission = ?";
    
    // Prepare the statement
    $stmt = mysqli_prepare($connect, $update_query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ss", $imageData, $permission_id);

    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        // Your success response
        http_response_code(200);
        echo json_encode(
            array(
                "StatusCode" => 200,
                'Status' => 'Success',
                "message" => "Success: Attachment updated successfully"
            )
        );
    } else {
        // Error handling
        http_response_code(404);
        echo json_encode(
            array(
                "StatusCode" => 400,
                'Status' => 'Error',
                "message" => "Error: Unable to update attachment - " . mysqli_error($connect)
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
