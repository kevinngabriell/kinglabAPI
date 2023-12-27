<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

function getAbsenceData() {
    global $connect;

    $result = [];

    $currentMonth = date('m');
    $currentYear = date('Y');
    $employee_id = $_GET['employee_id'];

    $query = "SELECT A1.employee_id, A1.date, A2.presence_type_name, COUNT(*) as count
              FROM absence_log A1
              JOIN presence_type A2 ON A1.presence_type = A2.id_presence_type
              WHERE MONTH(A1.date) = $currentMonth AND YEAR(A1.date) = $currentYear AND A1.employee_id = $employee_id
              GROUP BY A1.employee_id, A1.date";

    $result_set = $connect->query($query);

    while ($row = $result_set->fetch_assoc()) {
        $employee_id = $row['employee_id'];
        $log_date = $row['date'];
        $count = $row['count'];

        if ($count == 2) {
            $result[] = ['employee_id' => $employee_id, 'date' => $log_date, 'status' => 'valid'];
        } elseif ($count == 1) {
            $result[] = ['employee_id' => $employee_id, 'date' => $log_date, 'status' => 'invalid'];
        } elseif ($count == 0) {
            $result[] = ['employee_id' => $employee_id, 'date' => $log_date, 'status' => 'absent'];
        }
    }

    return $result;
}

function getAbsenceStatistics() {
    global $connect;

    $statistics = [
        'Tepat Waktu' => 0,
        'Tidak Hadir' => 0,
        'Terlambat' => 0,
        'Lembur' => 0,
        'Pulang Awal' => 0,
    ];

    $currentMonth = date('m');
    $currentYear = date('Y');

    $employee_id = $_GET['employee_id'];

    $query = "SELECT A1.employee_id, A1.date, A2.presence_type_name, COUNT(*) as count
              FROM absence_log A1
              JOIN presence_type A2 ON A1.presence_type = A2.id_presence_type
              WHERE MONTH(A1.date) = $currentMonth AND YEAR(A1.date) = $currentYear AND A1.employee_id = $employee_id
              GROUP BY A2.presence_type_name";

    $result_set = $connect->query($query);

    while ($row = $result_set->fetch_assoc()) {
        $status = $row['presence_type_name'];
        $count = $row['count'];

        $statistics[$status] = $count;
    }

    return $statistics;
}

$absenceStatistics = getAbsenceStatistics();

header('Content-Type: application/json');
echo json_encode($absenceStatistics, JSON_PRETTY_PRINT);

$connect->close();

?>