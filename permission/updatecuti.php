<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $leave_update = $_POST['leave_update'];
    $leave_before = $_POST['leave_before'];
    $exp_update = $_POST['exp_update'];
    $exp_before = $_POST['exp_before'];
    $employee_id = $_POST['employee_id'];

    $update_cuti_query = "UPDATE annual_leave SET leave_count = '$leave_update', expired_date = '$exp_before' WHERE employee_id = '$employee_id' AND leave_count = '$leave_before' AND expired_date = '$exp_before'";
    if ($connect->query($update_cuti_query) === TRUE) {
        $response = array(
            'status' => 'success',
            'message' => 'Cuti updated successfully.'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Error updating cuti: ' . $connect->error
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