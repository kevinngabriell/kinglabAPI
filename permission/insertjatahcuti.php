<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

$employeeid = $_POST['employee_id'];
$jatahcuti = $_POST['jatah_cuti'];
$exp_date = $_POST['exp_date'];


$insertcutiquery = "
    INSERT INTO annual_leave (employee_id, expired_date, leave_count)
    VALUES 
        ('$employeeid', '$exp_date', '$jatahcuti');
";

if (mysqli_query($connect, $insertcutiquery)) {
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
