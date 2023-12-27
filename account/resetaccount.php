<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $check_user_query = "SELECT username FROM users WHERE employee_id = '$id'";
    $check_user_result = mysqli_query($connect, $check_user_query);
    
    $check_is_user_already_exist_rows = $check_user_result->fetch_assoc();
    
    if ($check_is_user_already_exist_rows !== null) {
        $default_password = '123456';
        $password = password_hash($default_password, PASSWORD_DEFAULT);

        $update_user_pass_query = "UPDATE users SET password = '$password' WHERE employee_id = '$id' ";
        $update_user_pass_result = mysqli_query($connect, $update_user_pass_query);

        if ($update_user_pass_result) {
            http_response_code(200);
            echo json_encode(array("message" => "Password updated successfully"));
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Password updated failed"));
        }
    } else {
        http_response_code(300);
        echo json_encode(array("message" => "User not registered"));
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