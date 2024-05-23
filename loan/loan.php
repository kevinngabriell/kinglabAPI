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
        $employee_id = $_POST['employee_id'];
        $loan_amount = $_POST['loan_amount'];
        $loan_reason = $_POST['loan_reason'];
        $loan_topay = $_POST['loan_topay'];
        $status = $_POST['status'];
        $is_paid = $_POST['is_paid'];

        $query_one = "INSERT INTO loan (loan_id, employee_id, loan_amount, loan_reason, loan_topay, status, is_paid, insert_by, insert_dt) 
        VALUES (UUID(), '$employee_id', '$loan_amount', '$loan_reason', '$loan_topay', '$status', '$is_paid','$employee_id', '$currentDateTimeString');";

        if(mysqli_query($connect, $query_one)){
            $search_query = "SELECT loan_id FROM loan ORDER BY insert_dt DESC LIMIT 1";
            $result_last_id= $connect->query($search_query);
            $row = $result_last_id->fetch_assoc();
            $last_id = $row["loan_id"];

            $query_two = "INSERT INTO loan_log (loan_id, action, action_by, action_dt) VALUES ('$last_id', 'Pinjaman telah berhasil diajukan dan menunggu persetujuan atasan anda', '$employee_id', '$currentDateTimeString');";
            $query_three = "INSERT INTO loan_transaction(loan_id, transaction, amount, transaction_date) VALUES ('$last_id', 0,'$loan_amount', '$currentDateTimeString')";
            
            if(mysqli_query($connect, $query_two) && mysqli_query($connect, $query_three)){
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
                    "message" => "Error: Unable to insert loan data - " . mysqli_error($connect)
                )
            );
        }

    } else if ($action == '2'){
        $status_name = $_POST['status_name'];

        $query = "INSERT INTO loan_status (status_id, status_name) VALUES (UUID(), '$status_name');";

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
        $new_status = 'd46f57da-ec09-11ee-a';
        $loan_id = $_POST['loan_id'];
        $employee_id = $_POST['employee_id'];
        $spv_id = $_POST['spv_id'];
        $action = "Permohonan pinjaman karyawan telah ditolak oleh manager pada $currentDateTimeString";

        $query_one = "UPDATE loan SET status = '$new_status', update_by = '$spv_id', update_dt = '$currentDateTimeString' WHERE loan_id = '$loan_id'";
        $query_two = "INSERT INTO loan_log (loan_id, action, action_by, action_dt) VALUES ('$loan_id', '$action', '$spv_id', '$currentDateTimeString');";
        $query_three = "INSERT INTO notification_alert (receiver, id, sender, title, message, send_date) VALUES ('$employee_id', UUID(),'0000000015', 'Penolakan Pinjaman Karyawan', '$action', '$currentDateTimeString');";
        
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
    } else if ($action == '4'){
        $new_status = '5d45cbde-eb4c-11ee-a';
        $loan_id = $_POST['loan_id'];
        $employee_id = $_POST['employee_id'];
        $spv_id = $_POST['spv_id'];
        $employee_name = $_POST['employee_name'];
        $action = "Permohonan pinjaman karyawan telah diterima oleh manager dan menunggu persetujuan dari HRD pada $currentDateTimeString";

        $query_one = "UPDATE loan SET status = '$new_status', update_by = '$spv_id', update_dt = '$currentDateTimeString' WHERE loan_id = '$loan_id'";
        $query_two = "INSERT INTO loan_log (loan_id, action, action_by, action_dt) VALUES ('$loan_id', '$action', '$spv_id', '$currentDateTimeString');";
        $query_three = "INSERT INTO notification_alert (receiver, id, sender, title, message, send_date) VALUES ('$employee_id', UUID() ,'0000000015', 'Persetujuan Pinjaman Karyawan', '$action', '$currentDateTimeString');";
        
        $hrEmployeesQuery = "SELECT id FROM employee WHERE position_id = 'POS-HR-002' ;";
        $hrEmployeesResult = $connect->query($hrEmployeesQuery);

        if ($hrEmployeesResult->num_rows > 0) {
            while ($employee = $hrEmployeesResult->fetch_assoc()) {
                $receiverId = $employee['id'];

                $notification_send_hrd_query = "INSERT IGNORE INTO notification_alert 
                (id, sender, receiver, title, message, send_date) VALUES 
                (UUID(), '0000000015', '$receiverId', 'Persetujuan Pinjaman Karyawan', '$employee_name telah mengajukan permohonan perjalanan dinas dan membutuhkan persetujuan anda melalui portal HR. Silahkan akses melalui menu karyawan pada portal HR. Terima kasih', '$currentDateTimeString');";

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
    } else if ($action == '5'){
        $new_status = 'd726148b-ec09-11ee-a';
        $loan_id = $_POST['loan_id'];
        $employee_id = $_POST['employee_id'];
        $hrd_id = $_POST['hrd_id'];
        $action = "Permohonan pinjaman karyawan telah ditolak oleh HRD pada $currentDateTimeString";

        $query_one = "UPDATE loan SET status = '$new_status', update_by = '$hrd_id', update_dt = '$currentDateTimeString' WHERE loan_id = '$loan_id'";
        $query_two = "INSERT INTO loan_log (loan_id, action, action_by, action_dt) VALUES ('$loan_id', '$action', '$hrd_id', '$currentDateTimeString');";
        $query_three = "INSERT INTO notification_alert (receiver, id, sender, title, message, send_date) VALUES ('$employee_id', UUID(),'0000000015', 'Penolakan Pinjaman Karyawan', '$action', '$currentDateTimeString');";
        
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
    } else if ($action == '6'){
        $new_status = '601ddc2c-eb4c-11ee-a';
        $loan_id = $_POST['loan_id'];
        $employee_id = $_POST['employee_id'];
        $hrd_id = $_POST['hrd_id'];
        $employee_name = $_POST['employee_name'];
        $action = "Permohonan pinjaman karyawan telah disetujui oleh HRD pada $currentDateTimeString";

        $query_one = "UPDATE loan SET status = '$new_status', update_by = '$hrd_id', update_dt = '$currentDateTimeString' WHERE loan_id = '$loan_id'";
        $query_two = "INSERT INTO loan_log (loan_id, action, action_by, action_dt) VALUES ('$loan_id', '$action', '$hrd_id', '$currentDateTimeString');";
        $query_three = "INSERT INTO notification_alert (receiver, id, sender, title, message, send_date) VALUES ('$employee_id', UUID() ,'0000000015', 'Persetujuan Pinjaman Karyawan', '$action', '$currentDateTimeString');";
        
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
        $loan_id = $_POST['loan_id'];
        $amount = $_POST['amount'];
        $insert_by = $_POST['insert_by'];
        
        $insert_query = "INSERT INTO loan_transaction(loan_id, transaction, amount, transaction_date) VALUES ('$loan_id', 1, '$amount','$currentDateTimeString')";
        
        if(mysqli_query($connect, $insert_query)){ 
            $total_paid_query = "SELECT SUM(amount) AS total_paid FROM loan_transaction 
                                WHERE loan_id = '$loan_id' AND transaction = 1;";
            $result= $connect->query($total_paid_query);
            $row = $result->fetch_assoc();
            $total_paid = $row['total_paid'];
            
            // SELECT query to retrieve the total borrowed amount
            $borrowed_query = "SELECT loan_amount FROM loan WHERE loan_id = '$loan_id'";
            $result_borrowed= $connect->query($borrowed_query);
            $row_borrowed = $result_borrowed->fetch_assoc();
            $total_borrowed = $row_borrowed['loan_amount'];
            
            // Check if the total paid is enough to mark the kasbon as paid off
            if ($total_paid >= $total_borrowed) {
                $update_status_query = "UPDATE loan SET is_paid = 1 WHERE loan_id = '$loan_id'";
                if(mysqli_query($connect, $update_status_query)){ 
                    echo json_encode(array("StatusCode" => 200, "Status" => "Success", "Message" => "Kasbon transaction inserted successfully"));
                }
                
            }
            
            echo json_encode(array("StatusCode" => 200, "Status" => "Success", "Message" => "Kasbon transaction inserted successfully"));
            
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