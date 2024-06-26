<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

$employeeid = $_POST['employee_id'];
$absencelocation = $_POST['absence_location'];

$insertabsencemapping = "
    INSERT INTO absence_mapping (employee_id, absence_location)
VALUES ('$employeeid', '$absencelocation')
ON DUPLICATE KEY UPDATE absence_location = VALUES(absence_location);

";

if (mysqli_query($connect, $insertabsencemapping)) {
    http_response_code(200);
    echo json_encode(
        array(
            "StatusCode" => 200,
            'Status' => 'Success',
            "message" => "Success: Data inserted/updated successfully"
        )
    );
} else {
    http_response_code(404);
    echo json_encode(
        array(
            "StatusCode" => 404,
            'Status' => 'Error',
            "message" => "Error: Unable to insert/update data - " . mysqli_error($connect)
        )
    );
}
?>
