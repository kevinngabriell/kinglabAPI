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
        $duration_name = $_POST['duration_name'];

        $query = "INSERT INTO businesstrip_duration (duration_id, duration_name) VALUES (UUID(), '$duration_name')";

        if(mysqli_query($connect, $query)){
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
    } else if ($action == '2'){
        $payment_name = $_POST['payment_name'];

        $query = "INSERT INTO businesstrip_payment (payment_id, payment_name) VALUES (UUID(), '$payment_name')";

        if(mysqli_query($connect, $query)){
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
        $transport_name = $_POST['transport_name'];

        $query = "INSERT INTO businesstrip_transport (transport_id, transport_name) VALUES (UUID(), '$transport_name')";

        if(mysqli_query($connect, $query)){
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
        $employee_id = $_POST['employee_id'];
        $city = $_POST['city'];
        $duration = $_POST['duration'];
        $reason = $_POST['reason'];
        $team = $_POST['team'];
        $payment = $_POST['payment'];
        $transport = $_POST['transport'];
        $currentDateTime = new DateTime();
        $indonesiaTimeZone = new DateTimeZone('Asia/Jakarta');
        $currentDateTime->setTimezone($indonesiaTimeZone);
        $currentDateTimeString = $currentDateTime->format("Y-m-d H:i:s");
        $team_one = $_POST['team_one'];
        $team_two = $_POST['team_two'];
        $team_three = $_POST['team_three'];
        $team_four = $_POST['team_four'];

        $query_one = "INSERT INTO businesstrip (businesstrip_id, employee_id, city, duration, reason, team, payment, transport, insert_by, insert_dt, status) VALUES (UUID(), '$employee_id', '$city', '$duration', '$reason', '$team', '$payment', '$transport', '$employee_id', '$currentDateTimeString', 'b08cb4ac-e68a-11ee-9');";
        if(mysqli_query($connect, $query_one)){

            $search_query = "SELECT businesstrip_id FROM businesstrip ORDER BY insert_dt DESC LIMIT 1";
            $result_last_id= $connect->query($search_query);
            $row = $result_last_id->fetch_assoc();
            $last_id = $row["businesstrip_id"];

            if($team_one != NULL){
                $query_two = "INSERT INTO businesstrip_team (businesstrip_id, team, member_name) VALUES ('$last_id', '$team', '$team_one');";
                if (!mysqli_query($connect, $query_two)) {
                    $statement = 'Nama member kosong';
                    return;
                }
            } 
            
            if ($team_two != NULL){
                $query_three = "INSERT INTO businesstrip_team (businesstrip_id, team, member_name) VALUES ('$last_id', '$team', '$team_two');";
                if (!mysqli_query($connect, $query_three)) {
                    $statement = 'Nama member kosong';
                    return;
                }
            } 
            
            if ($team_three != NULL){
                $query_four = "INSERT INTO businesstrip_team (businesstrip_id, team, member_name) VALUES ('$last_id', '$team', '$team_three');";
                if (!mysqli_query($connect, $query_four)) {
                    $statement = 'Nama member kosong';
                    return;
                }
            } 
            
            if ($team_four != NULL){
                $query_five = "INSERT INTO businesstrip_team (businesstrip_id, team, member_name) VALUES ('$last_id', '$team', '$team_four');";
                if (!mysqli_query($connect, $query_five)) {
                    $statement = 'Nama member kosong';
                    return;
                }
            }

            $query_six = "INSERT INTO businesstrip_log (businesstrip_id, action, action_by, action_dt) VALUES ('$last_id', 'Pengajuan perjalanan dinas anda telah berhasil dan menunggu persetujuan manager', '$employee_id', '$currentDateTimeString')";
            
            $employeeSPVQuery = "SELECT employee_spv, employee_name FROM employee WHERE id = '$employee_id';";
            $employeeSPVResult = $connect->query($employeeSPVQuery);
            $employeeSPVRow = $employeeSPVResult->fetch_assoc();
            $employeeSPV = $employeeSPVRow["employee_spv"];
            $employeeName = $employeeSPVRow["employee_name"];

            $query_notif = "INSERT IGNORE INTO notification_alert 
            (id, sender, receiver, title, message, send_date) VALUES 
            (UUID(), '0000000015', '$employeeSPV', 'Pengajuan Perjalanan Dinas', '$employeeName telah mengajukan permintaan perjalanan dinas melalui portal HR. Silahkan memberikan persetujuan atau penolakan anda atas permohonan tersebut melalui menu perjalanan dinas yang dapat anda akses pada halaman karyawan portal HR. Terima kasih .', '$currentDateTimeString');";
            
            if(mysqli_query($connect, $query_six) && mysqli_query($connect, $query_notif)){
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

        } else {
            http_response_code(400);
            echo json_encode(
                array(
                    "StatusCode" => 400,
                    'Status' => 'Error',
                    "message" => "Error: Unable to insert business trip data - " . mysqli_error($connect)
                )
            );
        }
    } else if ($action == '5'){
        $status_name = $_POST['status_name'];

        $query = "INSERT INTO businesstrip_status (status_id, status_name) VALUES (UUID(), '$status_name')";

        if(mysqli_query($connect, $query)){
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
    } else if ($action == '6'){
        $new_status = 'c9366158-e780-11ee-a';
        $businesstrip_id = $_POST['businesstrip_id'];
        $employee_id = $_POST['employee_id'];
        $spv_id = $_POST['spv_id'];
        $reason = $_POST['reason'];
        $action = "Permohonan perjalanan dinas telah ditolak oleh manager dengan alasan $reason pada $currentDateTimeString";

        $query_one = "UPDATE businesstrip SET status = '$new_status', update_by = '$spv_id', update_dt = '$currentDateTimeString' WHERE businesstrip_id = '$businesstrip_id'";
        $query_two = "INSERT INTO businesstrip_log (businesstrip_id, action, action_by, action_dt) VALUES ('$businesstrip_id', '$action', '$spv_id', '$currentDateTimeString');";
        $query_three = "INSERT INTO notification_alert (receiver, id, sender, title, message, send_date) VALUES ('$employee_id', UUID(),'0000000015', 'Penolakan Perjalanan Dinas', '$action', '$currentDateTimeString');";
        
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

    } else if ($action == '7'){
        $new_status = 'bac8f7f3-e68a-11ee-9';
        $businesstrip_id = $_POST['businesstrip_id'];
        $employee_id = $_POST['employee_id'];
        $spv_id = $_POST['spv_id'];
        $employee_name = $_POST['employee_name'];
        $action = "Permohonan perjalanan dinas telah diterima oleh manager dan menunggu persetujuan dari HRD pada $currentDateTimeString";

        $query_one = "UPDATE businesstrip SET status = '$new_status', update_by = '$spv_id', update_dt = '$currentDateTimeString' WHERE businesstrip_id = '$businesstrip_id'";
        $query_two = "INSERT INTO businesstrip_log (businesstrip_id, action, action_by, action_dt) VALUES ('$businesstrip_id', '$action', '$spv_id', '$currentDateTimeString');";
        $query_three = "INSERT INTO notification_alert (receiver, id, sender, title, message, send_date) VALUES ('$employee_id', UUID() ,'0000000015', 'Persetujuan Perjalanan Dinas', '$action', '$currentDateTimeString');";
        
        $hrEmployeesQuery = "SELECT id FROM employee WHERE position_id = 'POS-HR-002' ;";
        $hrEmployeesResult = $connect->query($hrEmployeesQuery);

        if ($hrEmployeesResult->num_rows > 0) {
            while ($employee = $hrEmployeesResult->fetch_assoc()) {
                $receiverId = $employee['id'];

                $notification_send_hrd_query = "INSERT IGNORE INTO notification_alert 
                (id, sender, receiver, title, message, send_date) VALUES 
                (UUID(), '0000000015', '$receiverId', 'Persetujuan Perjalanan Dinas', '$employee_name telah mengajukan permohonan perjalanan dinas dan membutuhkan persetujuan anda melalui portal HR. Silahkan akses melalui menu karyawan pada portal HR. Terima kasih', '$currentDateTimeString');";

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

    } else if ($action == '8'){
        $new_status = 'ccec3e68-e780-11ee-a';
        $businesstrip_id = $_POST['businesstrip_id'];
        $employee_id = $_POST['employee_id'];
        $hrd_id = $_POST['hrd_id'];
        $reason = $_POST['reason'];
        $action = "Permohonan perjalanan dinas telah ditolak oleh HRD dengan alasan $reason pada $currentDateTimeString";

        $query_one = "UPDATE businesstrip SET status = '$new_status', update_by = '$hrd_id', update_dt = '$currentDateTimeString' WHERE businesstrip_id = '$businesstrip_id'";
        $query_two = "INSERT INTO businesstrip_log (businesstrip_id, action, action_by, action_dt) VALUES ('$businesstrip_id', '$action', '$hrd_id', '$currentDateTimeString');";
        $query_three = "INSERT INTO notification_alert (receiver, id, sender, title, message, send_date) VALUES ('$employee_id', UUID(),'0000000015', 'Penolakan Perjalanan Dinas', '$action', '$currentDateTimeString');";
        
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
    } else if ($action == '9'){
        $new_status = 'bd4f304c-e68a-11ee-9';
        $businesstrip_id = $_POST['businesstrip_id'];
        $employee_id = $_POST['employee_id'];
        $hrd_id = $_POST['hrd_id'];
        $employee_name = $_POST['employee_name'];
        $action = "Permohonan perjalanan dinas telah disetujui oleh HRD pada $currentDateTimeString";

        $query_one = "UPDATE businesstrip SET status = '$new_status', update_by = '$hrd_id', update_dt = '$currentDateTimeString' WHERE businesstrip_id = '$businesstrip_id'";
        $query_two = "INSERT INTO businesstrip_log (businesstrip_id, action, action_by, action_dt) VALUES ('$businesstrip_id', '$action', '$spv_id', '$currentDateTimeString');";
        $query_three = "INSERT INTO notification_alert (receiver, id, sender, title, message, send_date) VALUES ('$employee_id', UUID() ,'0000000015', 'Persetujuan Perjalanan Dinas', '$action', '$currentDateTimeString');";
        
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