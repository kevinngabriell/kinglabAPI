<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $request_id = $_GET['request_id'];

    $query = "SELECT A2.employee_name, A3.department_name, A4.position_name FROM new_employee_request A1 JOIN employee A2 ON A2.id = A1.kualifikasi_serupa JOIN department A3 ON A3.department_id = A2.department_id JOIN position_db A4 ON A4.position_id = A2.position_id WHERE A1.id_new_employee_request = '$request_id';";
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