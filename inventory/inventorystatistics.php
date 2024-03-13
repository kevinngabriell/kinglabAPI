<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $employee_id = $_GET['employee_id'];

    $query_one = "SELECT COUNT(request_id) as my_request FROM inventory_request WHERE employee_id = '$employee_id';";
    $query_two = "SELECT COUNT(request_id) as need_approval FROM inventory_request WHERE last_status_request = 'INV-STA-001' OR last_status_request = 'INV-STA-002';";



} else {
    http_response_code(405);
    echo json_encode(
        array(
            'StatusCode' => 405,
            'Status' => 'Error',
            'Message' => 'Please check your method request'
        )
    );
}