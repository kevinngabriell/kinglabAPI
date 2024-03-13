<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $absence_id = $_POST['absence_id'];

    $updated_username_query = "UPDATE absence_log SET is_valid = 1 WHERE absence_id = '$absence_id';";

    if ($connect->query($updated_username_query) === TRUE) {
        $response = array(
            'status' => 'success',
            'message' => 'Username updated successfully.'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Error updating username: ' . $connect->error
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