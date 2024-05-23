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
        $saku_days_two = $_POST['saku_days_two'];
        $saku_days_three = $_POST['saku_days_three'];
        $saku_days_four = $_POST['saku_days_four'];
        $saku_days_five = $_POST['saku_days_five'];

        $transport_days = $_POST['transport_days'];

        $makan_days = $_POST['makan_days'];
        $makan_days_two = $_POST['makan_days_two'];
        $makan_days_three = $_POST['makan_days_three'];
        $makan_days_four = $_POST['makan_days_four'];
        $makan_days_five = $_POST['makan_days_five'];

        $entertain_days = $_POST['entertain_days'];
        $lain_days = $_POST['lain_days'];

        $tiket_price = $_POST['tiket_price'];
        $hotel_price = $_POST['hotel_price'];

        $saku_price = $_POST['saku_price'];
        $saku_price_two = $_POST['saku_price_two'];
        $saku_price_three = $_POST['saku_price_three'];
        $saku_price_four = $_POST['saku_price_four'];
        $saku_price_five = $_POST['saku_price_five'];

        $transport_price = $_POST['transport_price'];

        $makan_price = $_POST['makan_price'];
        $makan_price_two = $_POST['makan_price_two'];
        $makan_price_three = $_POST['makan_price_three'];
        $makan_price_four = $_POST['makan_price_four'];
        $makan_price_five = $_POST['makan_price_five'];

        $entertain_price = $_POST['entertain_price'];
        $lain_price = $_POST['lain_price'];

        $tiket_total = $_POST['tiket_total'];
        $hotel_total = $_POST['hotel_total'];

        $saku_total = $_POST['saku_total'];
        $saku_total_two = $_POST['saku_total_two'];
        $saku_total_three = $_POST['saku_total_three'];
        $saku_total_four = $_POST['saku_total_four'];
        $saku_total_five = $_POST['saku_total_five'];

        $transport_total = $_POST['transport_total'];

        $makan_total = $_POST['makan_total'];
        $makan_total_two = $_POST['makan_total_two'];
        $makan_total_three = $_POST['makan_total_three'];
        $makan_total_four = $_POST['makan_total_four'];
        $makan_total_five = $_POST['makan_total_five'];

        $entertain_total = $_POST['entertain_total'];
        $lain_total = $_POST['lain_total'];
        
        $query_two = "INSERT INTO lpd_transaction (lpd_id, transaction_name, count_days, price, total)
        VALUES
            ('$lpd_id', 'Tiket Pesawat', '$tiket_days', '$tiket_price', '$tiket_total'),
            ('$lpd_id', 'Hotel / Penginapan', '$hotel_days', '$hotel_price', '$hotel_total'),
            ('$lpd_id', 'Uang Saku', '$saku_days', '$saku_price', '$saku_total'),
            ('$lpd_id', 'Uang Saku 2', '$saku_days_two', '$saku_price_two', '$saku_total_two'),
            ('$lpd_id', 'Uang Saku 3', '$saku_days_three', '$saku_price_three', '$saku_total_three'),
            ('$lpd_id', 'Uang Saku 4', '$saku_days_four', '$saku_price_four', '$saku_total_four'),
            ('$lpd_id', 'Uang Saku 5', '$saku_days_five', '$saku_price_five', '$saku_total_five'),
            ('$lpd_id', 'Transport', '$transport_days', '$transport_price', '$transport_total'),
            ('$lpd_id', 'Uang Makan', '$makan_days', '$makan_price', '$makan_total'),
            ('$lpd_id', 'Uang Makan 2', '$makan_days_two', '$makan_price_two', '$makan_total_two'),
            ('$lpd_id', 'Uang Makan 3', '$makan_days_three', '$makan_price_three', '$makan_total_three'),
            ('$lpd_id', 'Uang Makan 4', '$makan_days_four', '$makan_price_four', '$makan_total_four'),
            ('$lpd_id', 'Uang Makan 5', '$makan_days_five', '$makan_price_five', '$makan_total_five'),
            ('$lpd_id', 'By Entertain', '$entertain_days', '$entertain_price', '$entertain_total'),
            ('$lpd_id', 'Lain-lain', '$lain_days', '$lain_price', '$lain_total');";
        
        $query_three = "INSERT INTO lpd_log (lpd_id, action, action_by, action_dt) VALUES ('$lpd_id', 'Laporan LPD telah berhasil dibuat pada $currentDateTimeString dan menunggu persetujuan HRD', '$employee_id','$currentDateTimeString');";

        $query_four = "UPDATE businesstrip SET status = 'e2701ec8-e780-11ee-a', update_by = '$employee_id', update_dt = '$currentDateTimeString' WHERE businesstrip_id = '$businesstrip_id'";
        $query_five = "INSERT INTO businesstrip_log (businesstrip_id, action, action_by, action_dt) VALUES ('$businesstrip_id', 'Laporan LPD telah dikumpulkan dan menunggu persetujuan HRD pada $currentDateTimeString', '$employee_id','$currentDateTimeString');";

        if(mysqli_query($connect, $query_one) && mysqli_query($connect, $query_two) && mysqli_query($connect, $query_three) && mysqli_query($connect, $query_four) && mysqli_query($connect, $query_five)){
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
    } else if ($action == '2'){
        $lpd_id = $_POST['lpd_id'];
        $businesstrip_id = $_POST['businesstrip_id'];
        $employee_id = $_POST['employee_id'];
        $requestor_id = $_POST['requestor_id'];

        $query_one = "UPDATE businesstrip SET status = 'f03cb8d0-e780-11ee-a' WHERE businesstrip_id = '$businesstrip_id'; ";
        $query_two = "INSERT businesstrip_log (businesstrip_id, action, action_by, action_dt) VALUES ('$businesstrip_id', 'Laporan LPD telah disetujui oleh pihak HRD pada tanggal $currentDateTimeString', '$employee_id', '$currentDateTimeString');";
        $query_three = "INSERT INTO lpd_log (lpd_id, action, action_by, action_dt) VALUES ('$lpd_id', 'Laporan LPD telah disetujui oleh pihak HRD pada tanggal $currentDateTimeString', '$employee_id', '$currentDateTimeString');";
        $query_four = "INSERT INTO notification_alert (receiver, id, sender, title, message, send_date) VALUES ('$requestor_id', UUID(), '0000000015', 'Persetujan LPD', 'Laporan LPD anda telah disetujui oleh HRD pada $currentDateTimeString dan masih menunggu persetujuan keuangan', '$currentDateTimeString');";
        
        $hrEmployeesQuery = "SELECT id FROM employee WHERE position_id = 'POS-HR-001' ;";
        $hrEmployeesResult = $connect->query($hrEmployeesQuery);

        if ($hrEmployeesResult->num_rows > 0) {
            while ($employee = $hrEmployeesResult->fetch_assoc()) {
                $receiverId = $employee['id'];

                $notification_send_hrd_query = "INSERT IGNORE INTO notification_alert 
                (id, sender, receiver, title, message, send_date) VALUES 
                (UUID(), '0000000015', '$receiverId', 'Persetujuan Laporan LPD', 'Laporan LPD dengan nomor $lpd_id membutuhkan persetujuan anda. Silahkan akses melalui menu karyawan pada portal HR. Terima kasih', '$currentDateTimeString');";

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

        if(mysqli_query($connect, $query_one) && mysqli_query($connect, $query_two) && mysqli_query($connect, $query_three) && mysqli_query($connect, $query_four)){
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
    
    } else if ($action == '3'){
        $lpd_id = $_POST['lpd_id'];
        $businesstrip_id = $_POST['businesstrip_id'];
        $employee_id = $_POST['employee_id'];
        $requestor_id = $_POST['requestor_id'];

        $query_one = "UPDATE businesstrip SET status = '5762055f-ea8a-11ee-a' WHERE businesstrip_id = '$businesstrip_id'; ";
        $query_two = "INSERT businesstrip_log (businesstrip_id, action, action_by, action_dt) VALUES ('$businesstrip_id', 'Laporan LPD ditolak oleh pihak HRD pada tanggal $currentDateTimeString', '$employee_id', '$currentDateTimeString');";
        $query_three = "INSERT INTO lpd_log (lpd_id, action, action_by, action_dt) VALUES ('$lpd_id', 'Laporan LPD ditolak oleh pihak HRD pada tanggal $currentDateTimeString', '$employee_id', '$currentDateTimeString');";
        $query_four = "INSERT INTO notification_alert (receiver, id, sender, title, message, send_date) VALUES ('$requestor_id', UUID(), '0000000015', 'Penolakan LPD', 'Laporan LPD anda ditolak oleh HRD pada $currentDateTimeString', '$currentDateTimeString');";
        
        if(mysqli_query($connect, $query_one) && mysqli_query($connect, $query_two) && mysqli_query($connect, $query_three) && mysqli_query($connect, $query_four)){
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
    } else if ($action == '4'){
        $lpd_id = $_POST['lpd_id'];
        $businesstrip_id = $_POST['businesstrip_id'];
        $employee_id = $_POST['employee_id'];
        $requestor_id = $_POST['requestor_id'];

        $query_one = "UPDATE businesstrip SET status = 'f442be5c-e780-11ee-a' WHERE businesstrip_id = '$businesstrip_id'; ";
        $query_two = "INSERT businesstrip_log (businesstrip_id, action, action_by, action_dt) VALUES ('$businesstrip_id', 'Laporan LPD telah disetujui oleh keuangan pada tanggal $currentDateTimeString', '$employee_id', '$currentDateTimeString');";
        $query_three = "INSERT INTO lpd_log (lpd_id, action, action_by, action_dt) VALUES ('$lpd_id', 'Laporan LPD telah disetujui oleh keuangan pada tanggal $currentDateTimeString', '$employee_id', '$currentDateTimeString');";
        $query_four = "INSERT INTO notification_alert (receiver, id, sender, title, message, send_date) VALUES ('$requestor_id', UUID(), '0000000015', 'Persetujuan LPD', 'Laporan LPD anda telah disetujui oleh keuangan pada $currentDateTimeString', '$currentDateTimeString');";
        
        if(mysqli_query($connect, $query_one) && mysqli_query($connect, $query_two) && mysqli_query($connect, $query_three) && mysqli_query($connect, $query_four)){
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
    } else if ($action == '5'){
        $lpd_id = $_POST['lpd_id'];
        $businesstrip_id = $_POST['businesstrip_id'];
        $employee_id = $_POST['employee_id'];
        $requestor_id = $_POST['requestor_id'];

        $query_one = "UPDATE businesstrip SET status = '5d086bfc-ea8a-11ee-a' WHERE businesstrip_id = '$businesstrip_id'; ";
        $query_two = "INSERT businesstrip_log (businesstrip_id, action, action_by, action_dt) VALUES ('$businesstrip_id', 'Laporan LPD telah ditolak oleh keuangan pada tanggal $currentDateTimeString', '$employee_id', '$currentDateTimeString');";
        $query_three = "INSERT INTO lpd_log (lpd_id, action, action_by, action_dt) VALUES ('$lpd_id', 'Laporan LPD telah ditolak oleh keuangan pada tanggal $currentDateTimeString', '$employee_id', '$currentDateTimeString');";
        $query_four = "INSERT INTO notification_alert (receiver, id, sender, title, message, send_date) VALUES ('$requestor_id', UUID(), '0000000015', 'Penolakan LPD', 'Laporan LPD anda telah ditolak oleh keuangan pada $currentDateTimeString', '$currentDateTimeString');";
        
        if(mysqli_query($connect, $query_one) && mysqli_query($connect, $query_two) && mysqli_query($connect, $query_three) && mysqli_query($connect, $query_four)){
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