<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT 
    employee_name,
    employee_dob,
    CEIL(DATEDIFF(NOW(), employee_dob) / 365) AS age
    FROM employee
    WHERE DATE_FORMAT(employee_dob, '%m-%d') BETWEEN DATE_FORMAT(NOW(), '%m-%d') AND DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 31 DAY), '%m-%d')
    ORDER BY employee_dob DESC
    LIMIT 3;";
    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
        $employee = array();

        while ($row = $result->fetch_assoc()) {
            $employee[] = $row;
        }

        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status' => 'Success',
                'Data' => $employee
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