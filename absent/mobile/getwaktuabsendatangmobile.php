<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $employee_id = $_GET['employee_id'];

    $query = "SELECT time FROM absence_log 
              WHERE DATE(absence_log.date) = CURDATE() 
              AND absence_type = 'ABSENCETYPE-001' 
              AND employee_id = '$employee_id';";

    $result = mysqli_query($connect, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $time = $row['time'];

            echo json_encode(array("time" => $time));
        } else {
            echo json_encode(array("time" => "- : -"));
        }
    } else {
        http_response_code(500);
        echo json_encode(array(
            "StatusCode" => 500,
            'Status' => 'Error',
            "message" => "Error: Unable to execute query - " . mysqli_error($connect)
        ));
    }

} else {
    http_response_code(404);
    echo json_encode(
        array(
            "StatusCode" => 404,
            'Status' => 'Error',
            "message" => "Error: Invalid method. Only GET requests are allowed."
        )
    );
}

?>