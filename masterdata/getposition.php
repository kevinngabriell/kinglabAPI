<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $companyId = $_GET['company_id'];
    $departmentId = $_GET['department_id'];

    $sql = "SELECT * FROM position_db WHERE company_id = '$companyId' AND department_id = '$departmentId'";
    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
        $positions = array();

        while ($row = $result->fetch_assoc()) {
            $positions[] = $row;
        }

        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status' => 'Success',
                'Data' => $positions
            )
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