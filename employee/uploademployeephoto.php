<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = $_POST['employee_id'];
    $photo = $_POST['photo'];

    $query = "UPDATE employee SET employee_image = ? WHERE id = ?";
    $stmt = mysqli_prepare($connect, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "si", $photo, $employee_id);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            http_response_code(200);
            echo json_encode(array(
                "StatusCode" => 200,
                'Status' => 'Success',
                "message" => "Success: Data updated successfully"
            ));
        } else {
            http_response_code(400);
            echo json_encode(array(
                "StatusCode" => 400,
                'Status' => 'Error',
                "message" => "Error: Unable to update data - " . mysqli_error($connect)
            ));
        }
    } else {
        http_response_code(500);
        echo json_encode(array(
            "StatusCode" => 500,
            'Status' => 'Error',
            "message" => "Error: Database error - " . mysqli_error($connect)
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
