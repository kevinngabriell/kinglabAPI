<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT COUNT(A1.id_new_employee_request) AS count FROM new_employee_request A1 JOIN new_request_employee_status_master A2 ON A2.id_status = A1.last_status WHERE A1.last_status = 'NEW-STATUS-003';";
    $result = $connect->query($query);

    if($result->num_rows > 0){
        $jatahCuti = array();

        while($row = $result->fetch_assoc()){
            $jatahCuti[] = $row;
        }

        http_response_code(200);
        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status' => 'Success',
                'Data' => $jatahCuti
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

?>