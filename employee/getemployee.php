<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'];

    if($action == '1'){
        $sql = "SELECT em.id ,em.employee_name, dp.department_name FROM employee em JOIN department dp ON em.department_id = dp.department_id;";
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
    } else if ($action == '2'){
        $employee_id = $_GET['employee_id'];
        $sql = "SELECT employee_spv FROM employee WHERE id = '$employee_id';";
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
    } else if ($action == '3'){
        $spv_id = $_GET['spv_id'];
        $sql = "SELECT employee_name FROM employee WHERE id = '$spv_id';";
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