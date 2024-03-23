<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $request_id = $_GET['request_id'];

    $query = "SELECT A2.employee_name, A1.employee_id, A3.department_name, A4.position_name, A1.item_request, A5.request_reason, A1.detail_request, A1.last_status_request, A6.status_name
    FROM inventory_request A1
    LEFT JOIN employee A2 ON A1.employee_id = A2.id
    LEFT JOIN department A3 ON A2.department_id = A3.department_id
    LEFT JOIN position_db A4 ON A2.position_id = A4.position_id
    LEFT JOIN inventory_request_reason A5 ON A1.reason_request = A5.id_reason
    LEFT JOIN inventory_request_status A6 ON A1.last_status_request = A6.status_id
    WHERE A1.request_id = '$request_id';";

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