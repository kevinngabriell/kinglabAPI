<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $company_id = isset($_GET['Company_ID']) ? $_GET['Company_ID'] : null;

    if (!$company_id) {
        http_response_code(400);
        echo json_encode(array('status' => 'error', 'message' => 'Missing Company_ID parameter'));
        exit;
    }

    try {
        $query = "SELECT out_time FROM company_settings WHERE Company_ID = '$company_id'";

        $result = $connect->query($query);

        if ($result === false) {
            throw new Exception($connect->error);
        }

        $row = $result->fetch_assoc();

        if (!$row) {
            http_response_code(404);
            echo json_encode(array('status' => 'error', 'message' => 'Company_ID not found'));
            exit;
        }

        echo json_encode(array('status' => 'success', 'out_time' => $row['out_time']));

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array('status' => 'error', 'message' => $e->getMessage()));
    }
} else {
    http_response_code(405);
    echo json_encode(array('status' => 'error', 'message' => 'Method Not Allowed'));
}

?>