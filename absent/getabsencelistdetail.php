<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

function getAbsenceData() {
    global $connect;

    $result = [];

    $currentMonth = $_GET['month'] ?? date('m');
    $currentYear = $_GET['year'] ?? date('Y');
    $employee_id = $_GET['employee_id'];

    $query = "SELECT A1.date, A1.time, A2.absence_type_name
              FROM absence_log A1
              JOIN absence_type A2 ON A2.id_absence_type = A1.absence_type
              WHERE A1.employee_id = '$employee_id'
                AND DATE_FORMAT(A1.date, '%Y-%m') = '$currentYear-$currentMonth'
              ORDER BY A1.date ASC";

    $result_set = $connect->query($query);

    if ($result_set) {
        while ($row = $result_set->fetch_assoc()) {
            $result[] = [
                'date' => $row['date'],
                'time' => $row['time'],
                'absence_type_name' => $row['absence_type_name'],
            ];
        }

        if (!empty($result)) {
            return ['Status' => 'Success', 'Data' => $result];
        } else {
            return ['Status' => 'Error', 'Code' => 404, 'Message' => 'No data found for the given parameters'];
        }
    } else {
        return ['Status' => 'Error', 'Code' => 500, 'Message' => 'Internal Server Error'];
    }
}

$absenceData = getAbsenceData();

http_response_code($absenceData['Status'] === 'Success' ? 200 : ($absenceData['Code'] ?? 500));

header('Content-Type: application/json');
echo json_encode($absenceData, JSON_PRETTY_PRINT);

$connect->close();
?>
