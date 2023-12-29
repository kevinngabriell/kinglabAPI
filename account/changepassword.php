<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $new_pass = $_POST['new_pass'];
    $username = $_POST['username'];

    $password_crypted = password_hash($new_pass, PASSWORD_BCRYPT);

    $updated_password_query = "UPDATE users SET password = '$password_crypted' WHERE username = '$username';";

    if ($connect->query($updated_password_query) === TRUE) {
        $response = array(
            'status' => 'success',
            'message' => 'Password updated successfully.'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Error updating password: ' . $connect->error
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