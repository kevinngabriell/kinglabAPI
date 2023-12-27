<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

function fetchData($employeeId) {
    global $connect;

    $stmt = $connect->prepare("SELECT A2.company_name, LEFT(A2.company_address, 15) AS company_address, LEFT(A1.employee_name, 15) AS employee_name, A3.employee_email, A4.position_name
        FROM employee A1
        JOIN company A2 ON A1.company_id = A2.company_id
        JOIN employee_contact_details_db A3 ON A1.id = A3.id
        JOIN position_db A4 ON A1.position_id = A4.position_id
        WHERE A1.id = ?");
    $stmt->bind_param("s", $employeeId);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();

    return $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $employeeId = $_POST['employee_id'];

    $resultData = fetchData($employeeId);

    if ($resultData) {
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