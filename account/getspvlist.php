<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $query = "SELECT A1.employee_name, A1.id
    FROM employee A1
    JOIN position_db A2 ON A1.position_id = A2.position_id
    WHERE A2.position_name LIKE '%Manager%';";
    $result = $connect->query($query);

    if($result->num_rows > 0){

        $listSPV = array();

        while($row = $result->fetch_assoc()){
            $listSPV[] = $row;
        }

        http_response_code(200);
        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status' => 'Success',
                'Data' => $listSPV
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
            'StatusCode' => 404,
            'Status' => 'Error',
            'Message' => 'Please check your method request'
        )
    );
}

?>