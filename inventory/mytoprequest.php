<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $employee_id = $_GET['employee_id'];

    $query = "SELECT A2.employee_name, A3.status_name, A1.item_request
    FROM inventory_request A1
    LEFT JOIN employee A2 ON A1.employee_id = A2.id
    LEFT JOIN inventory_request_status A3 ON A1.last_status_request = A3.status_id
    WHERE A1.employee_id = '$employee_id' ORDER BY A1.insert_dt DESC LIMIT 3;";

$result = $connect->query($query);

if($result->num_rows > 0){

    $jumlahCuti = array();

    while($row = $result->fetch_assoc()){
        $jumlahCuti[] = $row;
    }

    http_response_code(200);
    echo json_encode(
        array(
            'StatusCode' => 200,
            'Status' => 'Success',
            'Data' => $jumlahCuti
        )
    );

} else{
    http_response_code(400);
    echo json_encode(
        array(
            'StatusCode' => 400,
            'Status' => 'Not Found',
            "message" => "No found"
        )
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