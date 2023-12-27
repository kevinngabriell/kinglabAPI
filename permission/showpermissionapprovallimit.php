<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

    $query = "SELECT A1.id_permission, A3.permission_type_name, A2.employee_name ,A1.permission_date, A4.permission_status_name
    FROM permission_log A1
    JOIN employee A2 ON A1.employee_id = A2.id
    JOIN permission_type_master A3 ON A1.permission_type = A3.id_permission_type
    JOIN permission_status_master A4 ON A1.last_permission_status = A4.id_permission_status
    WHERE A2.employee_spv = '$id'ORDER BY A1.id_permission DESC LIMIT 3;";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) > 0) {
        $permission = array();

        while ($row = $result->fetch_assoc()) {
            $permission[] = $row;
        };

        http_response_code(200);
        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status' => 'Success',
                'Data' => $permission
            )
        );
    } else {
        http_response_code(404);
        echo json_encode(
            array(
                'StatusCode' => 404,
                'Status' => 'Not Found',
                "message" => "No found"
            )
        );
    }
} else {
    http_response_code(400);
    echo json_encode(
        array(
            'StatusCode' => 400,
            'Status' => 'Error',
            'Message' => 'Please check your method request'
        )
    );
}

?>