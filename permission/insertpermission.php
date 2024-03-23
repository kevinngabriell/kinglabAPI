<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    //pulang awal permission 
    if($action == '1'){
        date_default_timezone_set('Asia/Jakarta');
        $currentTime = date('H:i');
        $startTime = '13:00';
        $endTime = '19:00';

        if ($currentTime >= $startTime && $currentTime <= $endTime) {
            $id = $_POST['id'];
            $permission_type = 'PER-TYPE-001';
            $permission_date = $_POST['permission_date'];
            $permission_reason = $_POST['permission_reason'];
            $permission_time = $_POST['permission_time'];
            $last_permission_status = 'PER-STATUS-001';
            $date_now = $_POST['date_now'];
            $action = 'Input izin pulang awal telah berhasil dilakukan';
    
            $query = "INSERT IGNORE INTO permission_log 
            (id_permission, permission_type, `employee_id`, `permission_date`, `permission_reason`, `permission_time`, `last_permission_status`, `reject_reason`, `created_by`, `created_dt`, `update_by`, `update_dt`) 
            VALUES (UUID(), '$permission_type', '$id', '$permission_date', '$permission_reason', '$permission_time', '$last_permission_status', NULL, '$id', '$date_now', NULL, NULL);"; 
    
            if (mysqli_query($connect, $query)) {
                $last_permission_id_query = "SELECT id_permission FROM permission_log ORDER BY id_permission DESC LIMIT 1;";
                $result_last_permission_id = $connect->query($last_permission_id_query);
                $row = $result_last_permission_id->fetch_assoc();
                $last_permission_id = $row["id_permission"];

                $employeeNameQuery = "SELECT employee_name FROM employee WHERE id = '$id';";
                $employeeNameResult = $connect->query($employeeNameQuery);
                $employeeNameRow = $employeeNameResult->fetch_assoc();
                $employeeName = $employeeNameRow["employee_name"];

                $employeeSPVQuery = "SELECT employee_spv FROM employee WHERE id = '$id';";
                $employeeSPVResult = $connect->query($employeeSPVQuery);
                $employeeSPVRow = $employeeSPVResult->fetch_assoc();
                $employeeSPV = $employeeSPV["employee_spv"];

                $query_history = "INSERT IGNORE INTO permission_history 
                (id, permission_id, action, action_by, action_dt) VALUES 
                (NULL, '$last_permission_id', '$action', '$id', '$date_now');";

                $notification_send_manager_query = "INSERT IGNORE INTO notification_alert 
                (id, sender, receiver, title, message, send_date) VALUES 
                (UUID(), '0000000015', '$employeeSPV', 'Pengajuan Izin Pulang Awal', '$employeeName telah mengajukan permintaan pulang awal melalui portal HR. Silahkan memberikan persetujuan atau penolakan anda atas izin tersebut melalui menu persetujuan izin yang dapat anda akses pada halaman awal portal HR. Terima kasih .', '$date_now');";
                
                $hrEmployeesQuery = "SELECT id FROM employee WHERE position_id = 'POS-HR-002' ;";
                $hrEmployeesResult = $connect->query($hrEmployeesQuery);

                if ($hrEmployeesResult->num_rows > 0) {
                    while ($employee = $hrEmployeesResult->fetch_assoc()) {
                        $receiverId = $employee['id'];

                        $notification_send_hrd_query = "INSERT IGNORE INTO notification_alert 
                        (id, sender, receiver, title, message, send_date) VALUES 
                        (UUID(), '0000000015', '$receiverId', 'Pengajuan Izin Pulang Awal', '$employeeName telah mengajukan permintaan pulang awal melalui portal HR. Status permohonan saat ini masih menunggu persetujuan manager.', '$date_now');";

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

                if(mysqli_query($connect, $query_history) && mysqli_query($connect, $notification_send_manager_query)) {
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
                http_response_code(500);
                echo json_encode([
                    "StatusCode" => 500,
                    'Status' => 'Error',
                    "message" => "Error: Unable to insert data - " . mysqli_error($connect)
                ]);
            }
        } else {
            http_response_code(403);
            echo json_encode([
                "StatusCode" => 403,
                'Status' => 'Error',
                "message" => "Error: Operation allowed only between 13:00 to 17:00 WIB"
            ]);
        }
    //datang telat permission    
    } else if ($action == '2') {
        date_default_timezone_set('Asia/Jakarta');
        $id = $_POST['id'];
        $permission_type = 'PER-TYPE-002';
        $permission_date = $_POST['permission_date'];
        $permission_reason = $_POST['permission_reason'];
        $permission_time = $_POST['permission_time'];
        $last_permission_status = 'PER-STATUS-001';
        $date_now = $_POST['date_now'];
        $action = 'Input izin datang telat telah berhasil dilakukan';

        $dateTimeString = $permission_date . ' ' . $permission_time;
        $dateTimeParts = explode(' ', $dateTimeString);
        if (count($dateTimeParts) > 2) {
            // This assumes the date and time are the first two parts of the string
            $dateTimeString = $dateTimeParts[0] . ' ' . $dateTimeParts[1];
        }
        
        $inputTimestamp = strtotime($dateTimeString);
        $currentTimestamp = time();
        $timeDifference = $inputTimestamp - $currentTimestamp;
        $timeDifferenceHours = $timeDifference / 3600;

        if ($timeDifference >= 86400) {
            http_response_code(403);
            echo json_encode([
                "StatusCode" => 403,
                'Status' => 'Error',
                "message" => "Error: Operation allowed only 24 hours before"
            ]);
        } else {
            $query = "INSERT IGNORE INTO permission_log 
                (id_permission, permission_type, `employee_id`, `permission_date`, `permission_reason`, `permission_time`, `cuti_phone`, `start_date`, `end_date`, `pengganti_cuti`, `last_permission_status`, `reject_reason`, `created_by`, `created_dt`, `update_by`, `update_dt`) 
                VALUES (UUID(), '$permission_type', '$id', '$permission_date', '$permission_reason', '$permission_time', NULL, NULL, NULL, NULL, '$last_permission_status', NULL, '$id', '$date_now', '$id', '$date_now');";

            if (mysqli_query($connect, $query)) {
                $last_permission_id_query = "SELECT id_permission FROM permission_log ORDER BY id_permission DESC LIMIT 1;";
                $result_last_permission_id = $connect->query($last_permission_id_query);
                $row = $result_last_permission_id->fetch_assoc();
                $last_permission_id = $row["id_permission"];

                $employeeNameQuery = "SELECT employee_name FROM employee WHERE id = '$id';";
                $employeeNameResult = $connect->query($employeeNameQuery);
                $employeeNameRow = $employeeNameResult->fetch_assoc();
                $employeeName = $employeeNameRow["employee_name"];

                $employeeSPVQuery = "SELECT employee_spv FROM employee WHERE id = '$id';";
                $employeeSPVResult = $connect->query($employeeSPVQuery);
                $employeeSPVRow = $employeeSPVResult->fetch_assoc();
                $employeeSPV = $employeeSPV["employee_spv"];

                $query_history = "INSERT IGNORE INTO permission_history 
                (id, permission_id, action, action_by, action_dt) VALUES 
                (NULL, '$last_permission_id', '$action', '$id', '$date_now');";

                $notification_send_manager_query = "INSERT IGNORE INTO notification_alert 
                (id, sender, receiver, title, message, send_date) VALUES 
                (UUID(), '0000000015', '$employeeSPV', 'Pengajuan Izin Datang Telat', '$employeeName telah mengajukan permintaan datang telat melalui portal HR. Silahkan memberikan persetujuan atau penolakan anda atas izin tersebut melalui menu persetujuan izin yang dapat anda akses pada halaman awal portal HR. Terima kasih .', '$date_now');";
                
                $hrEmployeesQuery = "SELECT id FROM employee WHERE position_id = 'POS-HR-002' ;";
                $hrEmployeesResult = $connect->query($hrEmployeesQuery);

                if ($hrEmployeesResult->num_rows > 0) {
                    while ($employee = $hrEmployeesResult->fetch_assoc()) {
                        $receiverId = $employee['id'];

                        $notification_send_hrd_query = "INSERT IGNORE INTO notification_alert 
                        (id, sender, receiver, title, message, send_date) VALUES 
                        (UUID(), '0000000015', '$receiverId', 'Pengajuan Izin Datang Telat', '$employeeName telah mengajukan permintaan datang telat melalui portal HR. Status permohonan saat ini masih menunggu persetujuan manager.', '$date_now');";

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

                if(mysqli_query($connect, $query_history) && mysqli_query($connect, $notification_send_manager_query)) {
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
                http_response_code(500);
                echo json_encode([
                    "StatusCode" => 500,
                    'Status' => 'Error',
                    "message" => "Error: Unable to insert data - " . mysqli_error($connect)
                ]);
            }
        }
    //cuti tahunan permission
    } else if ($action == '3') {
        $permissionType = 'PER-TYPE-003';
        $employeeId = $_POST['employee_id'];
        $cutiPhone = $_POST['cuti_phone'];
        $startCuti = $_POST['start_cuti'];
        $endCuti = $_POST['end_cuti'];
        $penggantiCuti = $_POST['pengganti_cuti'];
        $permissionReason = $_POST['permission_reason'];
        $lastPermissionStatus = 'PER-STATUS-001';
        $createdBy = $_POST['created_by'];
        $createdDt = $_POST['created_dt'];
        $date_now = $_POST['date_now'];
        $action = 'Input cuti tahunan telah berhasil dilakukan';
        $datetime1 = new DateTime($startCuti);
        $datetime2 = new DateTime($endCuti);
        $interval = $datetime1->diff($datetime2);
        $jumlahHariCuti = $interval->days;

        $queryGetSisaCuti = "SELECT leave_count FROM annual_leave WHERE employee_id = '$employeeId' AND expired_date > CURDATE();";
        $resultGetSisaCuti = mysqli_query($connect, $queryGetSisaCuti);
        
        if ($resultGetSisaCuti) {
            $rowGetSisaCuti = mysqli_fetch_assoc($resultGetSisaCuti);
            if ($rowGetSisaCuti) {
                $sisacuti = $rowGetSisaCuti['leave_count'];
            }
    
            if ($sisacuti >= $jumlahHariCuti) {
                $a = $sisacuti - $jumlahHariCuti;
    
                $queryUpdateEmployee = "UPDATE annual_leave SET leave_count = $a WHERE employee_id = '$employeeId';";
                $resultUpdateEmployee = mysqli_query($connect, $queryUpdateEmployee);
    
                $queryInsertPermission = "INSERT INTO permission_log
                (`id_permission`, `permission_type`, `employee_id`, `permission_date`, `permission_reason`, `permission_time`, 
                `cuti_phone`, `start_date`, `end_date`, `pengganti_cuti`, `last_permission_status`, `reject_reason`, 
                `created_by`, `created_dt`, `update_by`, `update_dt`) 
                VALUES 
                (UUID(), '$permissionType', '$employeeId', NULL, '$permissionReason', NULL, '$cutiPhone', '$startCuti', '$endCuti', '$penggantiCuti', '$lastPermissionStatus', NULL, '$createdBy', '$createdDt', NULL, NULL)";
                
                if(mysqli_query($connect, $queryInsertPermission)) {
                    $last_permission_id_query = "SELECT id_permission FROM permission_log ORDER BY id_permission DESC LIMIT 1;";
                    $result_last_permission_id = $connect->query($last_permission_id_query);
                    $row = $result_last_permission_id->fetch_assoc();
                    $last_permission_id = $row["id_permission"];

                    $employeeNameQuery = "SELECT employee_name FROM employee WHERE id = '$createdBy';";
                    $employeeNameResult = $connect->query($employeeNameQuery);
                    $employeeNameRow = $employeeNameResult->fetch_assoc();
                    $employeeName = $employeeNameRow["employee_name"];

                    $employeeSPVQuery = "SELECT employee_spv FROM employee WHERE id = '$createdBy';";
                    $employeeSPVResult = $connect->query($employeeSPVQuery);
                    $employeeSPVRow = $employeeSPVResult->fetch_assoc();
                    $employeeSPV = $employeeSPV["employee_spv"];

                    $query_history = "INSERT INTO permission_history 
                    (id, permission_id, action, action_by, action_dt) VALUES 
                    (NULL, '$last_permission_id', '$action', '$createdBy', '$date_now');";
                    
                    $notification_send_manager_query = "INSERT IGNORE INTO notification_alert 
                    (id, sender, receiver, title, message, send_date) VALUES 
                    (UUID(), '0000000015', '$employeeSPV', 'Pengajuan Cuti Tahunan', '$employeeName telah mengajukan permintaan cuti tahunan melalui portal HR. Silahkan memberikan persetujuan atau penolakan anda atas izin tersebut melalui menu persetujuan izin yang dapat anda akses pada halaman awal portal HR. Terima kasih .', '$date_now');";
                    
                    $hrEmployeesQuery = "SELECT id FROM employee WHERE position_id = 'POS-HR-002' ;";
                    $hrEmployeesResult = $connect->query($hrEmployeesQuery);

                    if ($hrEmployeesResult->num_rows > 0) {
                        while ($employee = $hrEmployeesResult->fetch_assoc()) {
                            $receiverId = $employee['id'];

                            $notification_send_hrd_query = "INSERT INTO notification_alert 
                            (id, sender, receiver, title, message, send_date) VALUES 
                            (UUID(), '0000000015', '$receiverId', 'Pengajuan Cuti Tahunan', '$employeeName telah mengajukan permintaan cuti tahunan melalui portal HR. Status permohonan saat ini masih menunggu persetujuan manager.', '$date_now');";

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

                    if(mysqli_query($connect, $query_history) && mysqli_query($connect, $notification_send_manager_query)) {
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
                }
    
            } else {
                http_response_code(206);
                echo json_encode(array("status" => "Error", "message" => "Jatah cuti anda tidak cukup $sisacuti"));
            }
    
        } else {
            http_response_code(500);
            echo json_encode(array("status" => "Error", "message" => "Error: Unable to fetch remaining leave days - " . mysqli_error($connect)));
        }
    
    //lembur permission
    } else if ($action == '4') {
        $id = $_POST['id'];
        $permission_type = 'PER-TYPE-004';
        $overtime_date = $_POST['overtime_date'];
        $overtime_start = $_POST['overtime_start'];
        $overtime_end = $_POST['overtime_end'];
        $overtime_reason = $_POST['overtime_reason'];
        $last_permission_status = 'PER-STATUS-001';
        $date_now = $_POST['date_now'];
        $action = 'Input izin lembur telah berhasil dilakukan';

        $query = "INSERT INTO permission_log 
        (id_permission, permission_type, `employee_id`, `permission_date`,`start_time`, `end_time`, `keperluan`, `last_permission_status`, `created_by`, `created_dt`) 
        VALUES (UUID(), '$permission_type', '$id', '$overtime_date', '$overtime_start', '$overtime_end', '$overtime_reason', '$last_permission_status', '$id', '$date_now');";
    
        if (mysqli_query($connect, $query)) {
            $last_permission_id_query = "SELECT id_permission FROM permission_log ORDER BY id_permission DESC LIMIT 1;";
            $result_last_permission_id = $connect->query($last_permission_id_query);
            $row = $result_last_permission_id->fetch_assoc();
            $last_permission_id = $row["id_permission"];

            $employeeNameQuery = "SELECT employee_name FROM employee WHERE id = '$id';";
            $employeeNameResult = $connect->query($employeeNameQuery);
            $employeeNameRow = $employeeNameResult->fetch_assoc();
            $employeeName = $employeeNameRow["employee_name"];

            $employeeSPVQuery = "SELECT employee_spv FROM employee WHERE id = '$id';";
            $employeeSPVResult = $connect->query($employeeSPVQuery);
            $employeeSPVRow = $employeeSPVResult->fetch_assoc();
            $employeeSPV = $employeeSPV["employee_spv"];

            $query_history = "INSERT IGNORE INTO permission_history 
            (id, permission_id, action, action_by, action_dt) VALUES 
            (NULL, '$last_permission_id', '$action', '$id', '$date_now');";

            $notification_send_manager_query = "INSERT IGNORE INTO notification_alert 
            (id, sender, receiver, title, message, send_date) VALUES 
            (UUID(), '0000000015', '$employeeSPV', 'Pengajuan Izin Lembur', '$employeeName telah mengajukan permintaan lembur melalui portal HR. Silahkan memberikan persetujuan atau penolakan anda atas izin tersebut melalui menu persetujuan izin yang dapat anda akses pada halaman awal portal HR. Terima kasih .', '$date_now');";
            
            $hrEmployeesQuery = "SELECT id FROM employee WHERE position_id = 'POS-HR-002' ;";
            $hrEmployeesResult = $connect->query($hrEmployeesQuery);

            if ($hrEmployeesResult->num_rows > 0) {
                while ($employee = $hrEmployeesResult->fetch_assoc()) {
                    $receiverId = $employee['id'];

                    $notification_send_hrd_query = "INSERT IGNORE INTO notification_alert 
                    (id, sender, receiver, title, message, send_date) VALUES 
                    (UUID(), '0000000015', '$receiverId', 'Pengajuan Izin Lembur', '$employeeName telah mengajukan permintaan lembur melalui portal HR. Status permohonan saat ini masih menunggu persetujuan manager.', '$date_now');";

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

            if(mysqli_query($connect, $query_history) && mysqli_query($connect, $notification_send_manager_query)) {
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
            http_response_code(500);
            echo json_encode([
                "StatusCode" => 500,
                'Status' => 'Error',
                "message" => "Error: Unable to insert data - " . mysqli_error($connect)
            ]);
        }
    //sakit permission    
    } else if ($action == '5') {
        $id = $_POST['id'];
        $permission_type = 'PER-TYPE-005';
        $last_permission_status = 'PER-STATUS-001';
        $date_now = $_POST['date_now'];
        $action = 'Input izin sakit telah berhasil dilakukan';
        $attachment = base64_decode($_POST['attachment']);
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        $insert_query = "INSERT INTO permission_log (id_permission, permission_type, employee_id, start_date, end_date, attachment, created_by, created_dt, last_permission_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
        // Prepare the query
        $stmt = mysqli_prepare($connect, $insert_query);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "sssssssss", $uuid, $permission_type, $id, $start_date, $end_date, $attachment, $id, $date_now, $last_permission_status);

        // Generate UUID
        $uuid = uniqid();

        if (mysqli_stmt_execute($stmt)) {
            $last_permission_id_query = "SELECT id_permission FROM permission_log ORDER BY id_permission DESC LIMIT 1;";
            $result_last_permission_id = $connect->query($last_permission_id_query);
            $row = $result_last_permission_id->fetch_assoc();
            $last_permission_id = $row["id_permission"];

            $employeeNameQuery = "SELECT employee_name FROM employee WHERE id = '$id';";
            $employeeNameResult = $connect->query($employeeNameQuery);
            $employeeNameRow = $employeeNameResult->fetch_assoc();
            $employeeName = $employeeNameRow["employee_name"];

            $employeeSPVQuery = "SELECT employee_spv FROM employee WHERE id = '$id';";
            $employeeSPVResult = $connect->query($employeeSPVQuery);
            $employeeSPVRow = $employeeSPVResult->fetch_assoc();
            $employeeSPV = $employeeSPV["employee_spv"];

            $query_history = "INSERT IGNORE INTO permission_history 
            (id, permission_id, action, action_by, action_dt) VALUES 
            (NULL, '$last_permission_id', '$action', '$id', '$date_now');";

            $notification_send_manager_query = "INSERT IGNORE INTO notification_alert 
            (id, sender, receiver, title, message, send_date) VALUES 
            (UUID(), '0000000015', '$employeeSPV', 'Pengajuan Izin Sakit', '$employeeName telah mengajukan permintaan izin sakit melalui portal HR. Silahkan memberikan persetujuan atau penolakan anda atas izin tersebut melalui menu persetujuan izin yang dapat anda akses pada halaman awal portal HR. Terima kasih .', '$date_now');";
            
            $hrEmployeesQuery = "SELECT id FROM employee WHERE position_id = 'POS-HR-002' ;";
            $hrEmployeesResult = $connect->query($hrEmployeesQuery);

            if ($hrEmployeesResult->num_rows > 0) {
                while ($employee = $hrEmployeesResult->fetch_assoc()) {
                    $receiverId = $employee['id'];

                    $notification_send_hrd_query = "INSERT IGNORE INTO notification_alert 
                    (id, sender, receiver, title, message, send_date) VALUES 
                    (UUID(), '0000000015', '$receiverId', 'Pengajuan Izin Sakit', '$employeeName telah mengajukan permintaan izin sakit melalui portal HR. Status permohonan saat ini masih menunggu persetujuan manager.', '$date_now');";

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

            if(mysqli_query($connect, $query_history) && mysqli_query($connect, $notification_send_manager_query)) {
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
            http_response_code(400);
            echo json_encode(
                array(
                    "StatusCode" => 400,
                    'Status' => 'Error',
                    "message" => "Error: Unable to insert data - " . mysqli_error($connect)
                )
            );
        }
    } 

} else {
    http_response_code(405);
    echo json_encode([
        "StatusCode" => 405,
        'Status' => 'Error',
        "message" => "Error: Invalid method. Only POST requests are allowed."
    ]);
}