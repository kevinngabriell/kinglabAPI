<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT A1.id_new_employee_request, A1.posisi_diajukan, A3.department_name, A1.created_dt, A4.status_name FROM new_employee_request A1 JOIN employee A2 ON A2.id = A1.requestor_employee_id JOIN department A3 ON A3.department_id = A2.department_id JOIN new_request_employee_status_master A4 ON A4.id_status = A1.last_status;";
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