<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

$sql = "SELECT id FROM employee";
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $receiver = $row["id"];
        absenceLog($receiver, '2024-02-02', '17:30:00', 'Absen Melalui Web');
    }
} else {
    echo "No employees found in the database";
}

$connect->close(); // Change from $conn to $connect

function absenceLog($receiver, $date, $time, $location) {
    $id = uniqid();

    global $connect; // Add this line to access the global $connect variable

    $query = "INSERT IGNORE INTO absence_log (employee_id, date, time, location, absence_id, absence_type, presence_type) 
    VALUES ('$receiver', '$date', '$time', '$location', '$id','ABSENCETYPE-002', 'PRESENCE001')";

    if (mysqli_query($connect, $query)) {
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
}
?>
