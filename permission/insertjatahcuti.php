<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

$employeeid = $_POST['employee_id'];
$jatahcuti2023 = $_POST['jatah_cuti_2023'];
$jatahcuti2024 = $_POST['jatah_cuti_2024'];
$jatahcuti2025 = $_POST['jatah_cuti_2025'];
$jatahcuti2026 = $_POST['jatah_cuti_2026'];
$jatahcuti2027 = $_POST['jatah_cuti_2027'];
$jatahcuti2028 = $_POST['jatah_cuti_2028'];
$jatahcuti2029 = $_POST['jatah_cuti_2029'];
$jatahcuti2030 = $_POST['jatah_cuti_2030'];

$insertcutiquery = "
    INSERT INTO annual_leave (employee_id, year, leave_count)
    VALUES 
        ('$employeeid', '2023', '$jatahcuti2023'),
        ('$employeeid', '2024', '$jatahcuti2024'),
        ('$employeeid', '2025', '$jatahcuti2025'),
        ('$employeeid', '2026', '$jatahcuti2026'),
        ('$employeeid', '2027', '$jatahcuti2027'),
        ('$employeeid', '2028', '$jatahcuti2028'),
        ('$employeeid', '2029', '$jatahcuti2029'),
        ('$employeeid', '2030', '$jatahcuti2030')
    ON DUPLICATE KEY UPDATE leave_count = VALUES(leave_count);
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
