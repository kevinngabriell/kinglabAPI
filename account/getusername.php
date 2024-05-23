<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

function checkUsername($username) {
    global $connect;

    $stmt = $connect->prepare("SELECT A1.username, A2.employee_name
                        FROM users A1
                        JOIN employee A2 ON A1.employee_id = A2.id
                        WHERE A1.employee_id = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();

    return $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['employee_id'];
    
    $resultData = checkUsername($username);

    if($resultData){
        http_response_code(200);
        echo json_encode($resultData);
    } else {
        http_response_code(400);
        echo json_encode(
            array(
                'StatusCode' => 400,
                'Status' => 'Error Bad Request, Result not found !'
            )
        );
    }
    
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


?>