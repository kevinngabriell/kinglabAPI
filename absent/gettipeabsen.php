<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $employee_id = isset($_GET['employee_id']) ? $_GET['employee_id'] : null;

    if (!$employee_id) {
        http_response_code(400);
        echo json_encode(array('status' => 'error', 'message' => 'Missing employee_id parameter'));
        exit;
    }

    try {
        $query = "SELECT COUNT(*) AS absence_count
                  FROM absence_log
                  WHERE absence_log.employee_id = '$employee_id'
                  AND DATE(absence_log.date) = CURDATE()";

        $result = $connect->query($query);

        if ($result === false) {
            throw new Exception($connect->error);
        }

        $row = $result->fetch_assoc();

        $absenceCount = $row['absence_count'];

        $response = array();

        if ($absenceCount == 0) {
            $response['absence_type_id'] = 'ABSENCETYPE-001';
            $response['absence_type'] = 'Absen Masuk';
        } elseif ($absenceCount == 1) {
            $response['absence_type_id'] = 'ABSENCETYPE-002';
            $response['absence_type'] = 'Absen Pulang';
        } else {
            http_response_code(400);
            echo json_encode(array('status' => 'error', 'message' => 'Invalid absence count'));
            exit;
        }

        echo json_encode(array('status' => 'success', 'result' => $response));

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array('status' => 'error', 'message' => $e->getMessage()));
    }
} else {
    http_response_code(405);
    echo json_encode(array('status' => 'error', 'message' => 'Method Not Allowed'));
}

?>