<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if($action == '1'){
        $notification_id = $_POST['notification_id'];
        $query = "DELETE FROM notification_alert WHERE id = '$notification_id'";

        if(mysqli_query($connect, $query)){
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
                    "StatusCode" => 404,
                    'Status' => 'Success',
                    "message" => "Error: Unable to insert data - " . mysqli_error($connect)
                )
            );
        }
    } else if ($action == '2'){
        $employee_id = $_POST['employee_id'];
        $query = "DELETE FROM notification_alert WHERE receiver = '$employee_id'";

        if(mysqli_query($connect, $query)){
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
                    "StatusCode" => 404,
                    'Status' => 'Success',
                    "message" => "Error: Unable to insert data - " . mysqli_error($connect)
                )
            );
        }
    }
} else {
    http_response_code(405);
    echo json_encode([
        "StatusCode" => 405,
        'Status' => 'Error',
        "message" => "Error: Invalid method. Only POST requests are allowed."
    ]);
}