<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $employeeId = $_GET['employee_id'];

    $sql = "SELECT A1.employee_name, A2.position_name, A3.department_name, A4.employee_email, A4.employee_phone_number, A5.employee_status_name, A1.employee_pob, A1.employee_dob, A6.gender_name, A7.username
        FROM employee A1 
        JOIN position_db A2 ON A1.position_id = A2.position_id 
        JOIN department A3 ON A1.department_id = A3.department_id 
        JOIN employee_contact_details_db A4 ON A1.id = A4.id 
        JOIN employee_status A5 ON A1.employee_status_id = A5.employee_status_id 
        JOIN gender_db A6 ON A1.gender = A6.gender_id 
        JOIN users A7 ON A1.id = A7.employee_id
        WHERE A1.id = '$employeeId';";
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