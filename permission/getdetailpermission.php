<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $permission_id = $_GET['permission_id'];

    $query = "SELECT A2.employee_name, A3.department_name, A4.permission_type_name, A2.employee_id, A5.position_name, A1.permission_date , A1.permission_reason, A1.permission_time, A6.permission_status_name, A6.id_permission_status, A2.employee_spv, (SELECT employee_name FROM employee WHERE id = A1.created_by) AS created_by, A1.created_dt AS created_dt, (SELECT employee_name FROM employee WHERE id = A1.created_by) AS created_by, A1.created_dt, (SELECT employee_name FROM employee WHERE id = A1.update_by) AS update_by, A1.update_dt, A1.start_date, A1.end_date, A1.cuti_phone, (SELECT employee_name FROM employee WHERE id = A1.pengganti_cuti) AS pengganti_cuti, A1.permission_date, A1.keperluan, start_time, end_time
    FROM permission_log A1
    JOIN employee A2 ON A1.employee_id = A2.id
    JOIN department A3 ON A2.department_id = A3.department_id
    JOIN permission_type_master A4 ON A1.permission_type = A4.id_permission_type
    JOIN position_db A5 ON A2.position_id = A5.position_id
    JOIN permission_status_master A6 ON A1.last_permission_status = A6.id_permission_status
    WHERE A1.id_permission = '$permission_id';";
    $result = $connect->query($query);

    if($result->num_rows > 0){

        $detailPermission = array();

        while($row = $result->fetch_assoc()){
            $detailPermission[] = $row;
        }

        http_response_code(200);
        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status' => 'Success',
                'Data' => $detailPermission
            )
        );

    } else{
        http_response_code(400);
        echo json_encode(
            array(
                'StatusCode' => 400,
                'Status' => 'Not Found',
                "message" => "No found"
            )
        );
    }
} else {
    http_response_code(404);
    echo json_encode(
        array(
            'StatusCode' => 404,
            'Status' => 'Error',
            'Message' => 'Please check your method request'
        )
    );
}

?>