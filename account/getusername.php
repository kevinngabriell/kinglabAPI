<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

function checkUsername($username) {
    global $connect;

    $stmt = $connect->prepare("SELECT us.username, em.employee_name FROM users us JOIN employee em ON us.employee_id = em.id WHERE us.username = ?");
    $stmt->bind_param("s", $employeeId);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();

    return $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    
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