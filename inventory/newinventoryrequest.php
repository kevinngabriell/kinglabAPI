<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = $_POST['employee_id'];
    $inventaris = $_POST['inventaris'];
    $reason = $_POST['reason'];
    $keterangan = $_POST['keterangan'];
    $last_status_request = 'INV-STA-001';
    $action = "Pengajuan inventaris baru anda telah berhasil dilakukan. Menunggu persetujuan dari HRD";
    $jakartaTimezone = new DateTimeZone('Asia/Jakarta');
    $jakartaDatetime = new DateTime('now', $jakartaTimezone);
    $insertDatetime = $jakartaDatetime->format('Y-m-d H:i:s');

    $insertInventoryRequest = "INSERT INTO inventory_request (request_id, employee_id, item_request, reason_request, detail_request, last_status_request, insert_by, insert_dt) VALUES (UUID(), '$employee_id', '$inventaris', '$reason', '$keterangan', '$last_status_request', '$employee_id', '$insertDatetime');";

    if(mysqli_query($connect, $insertInventoryRequest)){

        $lastIDQuery = "SELECT request_id FROM inventory_request ORDER BY request_id DESC LIMIT 1;";
        $resultLastID = $connect->query($lastIDQuery);

        $row = $resultLastID->fetch_assoc();
        $lastID = $row["request_id"];

        $inventoryHistoryQuery = "INSERT INTO inventory_request_log (request_id, action, action_by, action_dt) VALUES ('$lastID','$action','$employee_id','$insertDatetime') ";

        if(mysqli_query($connect, $inventoryHistoryQuery)) {
            http_response_code(200);
            echo json_encode(
                array(
                    "StatusCode" => 200,
                    'Status' => 'Success',
                    "message" => "Success: Data inserted successfully"
                )
            );
        } else {
            http_response_code(404);
            echo json_encode(
                array(
                    "StatusCode" => 400,
                    'Status' => 'Error',
                    "message" => "Error: Unable to insert data - " . mysqli_error($connect)
                )
            );
        }

    } else {

    }


} else {
    http_response_code(405);
    echo json_encode(
        array(
            'StatusCode' => 405,
            'Status' => 'Error',
            'Message' => 'Please check your method request'
        )
    );
}

?>