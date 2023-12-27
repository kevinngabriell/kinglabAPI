<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

function validateLogin($username, $password) {
    global $connect;

    $stmt = $connect->prepare("SELECT employee_id, company_id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($employee_id, $company_id, $db_username, $db_password);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($password, $db_password)) {
        http_response_code(200);
        return array(
            'Status Code' => 200,
            'Status' => 'Success',
            'employee_id' => $employee_id,
            'company_id' => $company_id,
            'username' => $db_username
        );
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
    $password = $_POST['password'];

    $result = validateLogin($username, $password);

    header('Content-Type: application/json');
    echo json_encode($result);
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