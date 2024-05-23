<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $employeeId = $_GET['employee_id'];
    $startDate = $_GET['startDate'];
    $endDate = $_GET['endDate'];

    $query = "SELECT COUNT(A1.id_permission) as jumlah_pulang_awal
    FROM permission_log A1
    WHERE A1.permission_date BETWEEN '$startDate' AND '$endDate'
      AND A1.permission_type = 'PER-TYPE-001'
      AND A1.last_permission_status = 'PER-STATUS-003'
      AND A1.employee_id = '$employeeId';";

    $result = $connect->query($query);

    if($result->num_rows > 0){

        $jumlahCuti = array();

        while($row = $result->fetch_assoc()){
            $jumlahCuti[] = $row;
        }

        http_response_code(200);
        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status' => 'Success',
                'Data' => $jumlahCuti
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
            "StatusCode" => 404,
            'Status' => 'Error',
            "message" => "Error: Invalid method. Only POST requests are allowed."
        )
    );
}

?>