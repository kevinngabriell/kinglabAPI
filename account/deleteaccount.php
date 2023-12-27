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
        $delete_query = "DELETE FROM users WHERE employee_id = '$id' ";
        $delete_result = mysqli_query($connect, $delete_query);

        if ($delete_result) {
            http_response_code(200);
            echo json_encode(array("message" => "Account has been deleted"));
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Delete account failed"));
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