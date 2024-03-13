<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = $_POST['employee_id'];
    $photo = base64_decode($_POST['photo']);

    $query = "UPDATE employee SET employee_image = '$photo' WHERE id = '$employee_id'";

    if(mysqli_query($connect, $query)){
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

} else {
    http_response_code(404);
    echo json_encode(array(
        "StatusCode" => 404,
        'Status' => 'Error',
        "message" => "Error: Invalid method. Only POST requests are allowed."
    ));
}