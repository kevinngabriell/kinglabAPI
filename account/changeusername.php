<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $new_username = $_POST['new_username'];
    $username = $_POST['employee_id'];

    $updated_username_query = "UPDATE users SET username = '$new_username' WHERE employee_id = '$username';";

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