<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

function checkUserPosition($username) {
    global $connect;

    $position_id = null;
    $department_id = null;

    $stmt = $connect->prepare("SELECT em.position_id, em.department_id FROM users us JOIN employee em ON us.employee_id = em.id WHERE us.username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($position_id, $department_id);
    $stmt->fetch();
    $stmt->close();

    if ($position_id !== null && $department_id !== null) {
        $result = array(
            'Status Code' => 200,
            'position_id' => $position_id,
            'department_id' => $department_id,
        );
        echo json_encode($result);
    } else {
        http_response_code(400);
        echo json_encode(
            array(
                'StatusCode' => 400,
                'Status' => 'Error Bad Request, Result not found !'
            )
        );
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    checkUserPosition($username);
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