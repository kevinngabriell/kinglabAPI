<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $permission_id = $_GET['permission_id'];

    $query = "SELECT A1.permission_id, A1.action, A2.employee_name, A1.action_dt
    FROM permission_history A1
    JOIN employee A2 ON A1.action_by = A2.id
    WHERE A1.permission_id = '$permission_id';";
    $result = $connect->query($query);

    if($result->num_rows > 0){

        $detailPermission = array();

        while($row = $result->fetch_assoc()){
            $detailPermission[] = $row;
        }

        http_response_code(200);
        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status' => 'Success',
                'Data' => $detailPermission
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