<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeId = $_POST['employee_id'];
    $spvId = $_POST['spv_id'];

    $updated_spv_query = "UPDATE employee SET employee_spv = '$spvId' WHERE id = '$employeeId';";

    if ($connect->query($updated_spv_query) === TRUE) {
        $response = array(
            'status' => 'success',
            'message' => 'SPV update successfully.'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Error updating spv: ' . $connect->error
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