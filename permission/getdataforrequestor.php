<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

function fetchEmployeeData($id) {
    global $connect;

    $stmt = $connect->prepare("SELECT a1.employee_name, a1.employee_id, a2.department_name, a3.position_name
             FROM employee a1
             JOIN department a2 ON a1.department_id = a2.department_id
             JOIN position_db a3 ON a1.position_id = a3.position_id
             WHERE a1.id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    return $row;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $employeeId = $_POST['employee_id'];

    $fetchGetDataForPermission = fetchEmployeeData($employeeId);

    if($fetchGetDataForPermission) {
        http_response_code(200);
        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status'=> 'Success',
                'Data'=> $fetchGetDataForPermission
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