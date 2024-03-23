<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $currentDateTime = new DateTime();
    $indonesiaTimeZone = new DateTimeZone('Asia/Jakarta');
    $currentDateTime->setTimezone($indonesiaTimeZone);
    $currentDateTimeString = $currentDateTime->format("Y-m-d H:i:s");

    if($action == '1'){
        $lpd_id = $_POST['lpd_id'];
        $businesstrip_id = $_POST['businesstrip_id'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $project_name = $_POST['project_name'];
        $cash_advanced = $_POST['cash_advanced'];
        $lpd_desc = $_POST['lpd_desc'];
        $employee_id = $_POST['employee_id'];
        $employee_name = $_POST['employee_name'];

        $query_one = "INSERT INTO lpd (lpd_id, businesstrip_id, businesstrip_startdate, businesstrip_enddate, project_name, cash_advanced, lpd_desc, insert_by, insert_dt) VALUES 
                                      ('$lpd_id', '$businesstrip_id', '$start_date', '$end_date', '$project_name', '$cash_advanced', '$lpd_desc', '$employee_id', '$currentDateTimeString')";

        $tiket_days = $_POST['tiket_days'];
        $hotel_days = $_POST['hotel_days'];
        $saku_days = $_POST['saku_days'];
        $transport_days = $_POST['transport_days'];
        $makan_days = $_POST['makan_days'];
        $entertain_days = $_POST['entertain_days'];
        $lain_days = $_POST['lain_days'];

        $tiket_price = $_POST['tiket_price'];
        $hotel_price = $_POST['hotel_price'];
        $saku_price = $_POST['saku_price'];
        $transport_price = $_POST['transport_price'];
        $makan_price = $_POST['makan_price'];
        $entertain_price = $_POST['entertain_price'];
        $lain_price = $_POST['lain_price'];

        $tiket_total = $_POST['tiket_total'];
        $hotel_total = $_POST['hotel_total'];
        $saku_total = $_POST['saku_total'];
        $transport_total = $_POST['transport_total'];
        $makan_total = $_POST['makan_total'];
        $entertain_total = $_POST['entertain_total'];
        $lain_total = $_POST['lain_total'];
        
        $query_two = "INSERT INTO lpd_transaction (lpd_id, transaction_name, count_days, price, total)
        VALUES
            ('$lpd_id', 'Tiket Pesawat', '$tiket_days', '$tiket_price', '$tiket_total'),
            ('$lpd_id', 'Hotel / Penginapan', '$hotel_days', '$hotel_price', '$hotel_total'),
            ('$lpd_id', 'Uang Saku', '$saku_days', '$saku_price', '$saku_total'),
            ('$lpd_id', 'Transport', '$transport_days', '$transport_price', '$transport_total'),
            ('$lpd_id', 'Uang Makan', '$makan_days', '$makan_price', '$makan_total'),
            ('$lpd_id', 'By Entertain / Penginapan', '$entertain_days', '$entertain_price', '$entertain_total'),
            ('$lpd_id', 'Lain-lain', '$lain_days', '$lain_price', '$lain_total');";
        
        $query_three = "INSERT INTO lpd_log (lpd_id, action, action_by, action_dt) VALUES ('$lpd_id', 'Laporan LPD telah berhasil dibuat pada $currentDateTimeString dan menunggu persetujuan HRD', '$currentDateTimeString');";

        if(mysqli_query($connect, $query_one) && mysqli_query($connect, $query_two) && mysqli_query($connect, $query_three)){
            http_response_code(200);
            echo json_encode(
                array(
                    "StatusCode" => 200,
                    'Status' => 'Success',
                    "message" => "Success: Data inserted successfully"
                )
            );
        } else {
            http_response_code(400);
            echo json_encode(
                array(
                    "StatusCode" => 400,
                    'Status' => 'Error',
                    "message" => "Error: Unable to update data - " . mysqli_error($connect)
                )
            );
        }

        $hrEmployeesQuery = "SELECT id FROM employee WHERE position_id = 'POS-HR-002' ;";
        $hrEmployeesResult = $connect->query($hrEmployeesQuery);

        if ($hrEmployeesResult->num_rows > 0) {
            while ($employee = $hrEmployeesResult->fetch_assoc()) {
                $receiverId = $employee['id'];

                $notification_send_hrd_query = "INSERT IGNORE INTO notification_alert 
                (id, sender, receiver, title, message, send_date) VALUES 
                (UUID(), '0000000015', '$receiverId', 'Pengajuan LPD', '$employee_name telah mengajukan laporan perjalanan dinas dan membutuhkan persetujuan anda melalui portal HR. Silahkan akses melalui menu karyawan pada portal HR. Terima kasih', '$currentDateTimeString');";

                if (!mysqli_query($connect, $notification_send_hrd_query)) {
                    http_response_code(500);
                    echo json_encode([
                        "StatusCode" => 500,
                        'Status' => 'Error',
                        "message" => "Error: Unable to send notification to employee ID $receiverId - " . mysqli_error($connect)
                    ]);
                    return;
                }
            }
        }
    }

} else {
    http_response_code(404);
    echo json_encode(
        array(
            "StatusCode" => 404,
            'Status' => 'Error',
            "message" => "Error: Invalid method. Only POST requests are allowed."
        )
    );
}