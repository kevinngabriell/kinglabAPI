<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST["action"];

    //add new inventory category
    if($action == '1'){
        $inventory_category = $_POST["inventory_category"];
        
        $query = "INSERT INTO inventory_category (id_inventory_category, inventory_category_name) VALUES (UUID(), '$inventory_category');";

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
    //add new payment method for inventory
    } else if ($action == '2'){
        $payment_method = $_POST["payment_method"];
        
        $query = "INSERT INTO inventory_payment_method (id_payment_method, payment_method) VALUES (UUID(), '$payment_method');";

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
        $installment_name = $_POST["installment_name"];
        
        $query = "INSERT INTO inventory_installment (id_inventory_installment, inventory_installment_name) VALUES (UUID(), '$installment_name');";

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
        $request_id = $_POST['request_id'];
        $employee_id = $_POST['employee_id'];
        $currentDateTime = new DateTime();
        $indonesiaTimeZone = new DateTimeZone('Asia/Jakarta');
        $currentDateTime->setTimezone($indonesiaTimeZone);
        $currentDateTimeString = $currentDateTime->format("Y-m-d H:i:s");

        $search_query = "SELECT insert_by FROM inventory_request WHERE request_id = '$request_id'";
        $search_result = $connect->query($search_query);
        $row = $search_result->fetch_assoc();
        $requestor_id = $row["insert_by"];

        $update_request_query = "UPDATE inventory_request SET last_status_request = 'INV-STA-002', update_by = '$employee_id', update_dt = '$currentDateTimeString' WHERE request_id = '$request_id'";
        $insert_log = "INSERT INTO inventory_request_log (request_id, action, action_by, action_dt) VALUES ('$request_id', 'Permintaan telah disetujui oleh HRD dan menunggu persetujuan dari general manager', '$employee_id', '$currentDateTimeString')";
        if(mysqli_query($connect, $update_request_query) && mysqli_query($connect, $insert_log)){
            $send_notif_query = "INSERT INTO notification_alert (id, sender, receiver, title, message, send_date) VALUES (UUID(), '0000000015', '$requestor_id', 'Persetujuan Inventaris Baru', 'Permohonan inventaris anda telah disetujui oleh HRD dan menunggu persetujuan dari general manager.', '$currentDateTimeString');";

            if(mysqli_query($connect, $send_notif_query)){
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
                        "message" => "Error: Unable to insert notification data - " . mysqli_error($connect)
                    )
                );
            }
        } else {
            http_response_code(404);
            echo json_encode(
                array(
                    "StatusCode" => 400,
                    'Status' => 'Error',
                     "message" => "Error: Unable to update inventory data - " . mysqli_error($connect)
                )
            );
        }    
    } else if ($action == '5'){
        $request_id = $_POST['request_id'];
        $employee_id = $_POST['employee_id'];
        $reject_reason = $_POST['reject_reason'];
        $currentDateTime = new DateTime();
        $indonesiaTimeZone = new DateTimeZone('Asia/Jakarta');
        $currentDateTime->setTimezone($indonesiaTimeZone);
        $currentDateTimeString = $currentDateTime->format("Y-m-d H:i:s");
        
        $search_query = "SELECT insert_by FROM inventory_request WHERE request_id = '$request_id'";
        $search_result = $connect->query($search_query);
        $row = $search_result->fetch_assoc();
        $requestor_id = $row["insert_by"];

        $update_request_query = "UPDATE inventory_request SET reject_reason = '$reject_reason', last_status_request = 'INV-STA-004', update_by = '$employee_id', update_dt = '$currentDateTimeString' WHERE request_id = '$request_id'";
        $insert_log = "INSERT INTO inventory_request_log (request_id, action, action_by, action_dt) VALUES ('$request_id', 'Permintaan telah ditolak oleh HRD dengan alasan $reject_reason', '$employee_id', '$currentDateTimeString')";
        if(mysqli_query($connect, $update_request_query) && mysqli_query($connect, $insert_log)){
            $send_notif_query = "INSERT INTO notification_alert (id, sender, receiver, title, message, send_date) VALUES (UUID(), '0000000015', '$requestor_id', 'Penolakan Inventaris Baru', 'Mohon maaf, saat ini permintaan inventaris baru anda dengan nomor permintaan $request_id ditolak dengan alasan $reject_reason. Untuk pemeriksaan lebih detail silahkan periksa melalui menu inventaris', '$currentDateTimeString');";

            if(mysqli_query($connect, $send_notif_query)){
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
                        "message" => "Error: Unable to insert notification data - " . mysqli_error($connect)
                    )
                );
            }
        } else {
            http_response_code(404);
            echo json_encode(
                array(
                    "StatusCode" => 400,
                    'Status' => 'Error',
                     "message" => "Error: Unable to update inventory data - " . mysqli_error($connect)
                )
            );
        }    

    } else if ($action == '6'){
        $request_id = $_POST['request_id'];
        $employee_id = $_POST['employee_id'];
        $currentDateTime = new DateTime();
        $indonesiaTimeZone = new DateTimeZone('Asia/Jakarta');
        $currentDateTime->setTimezone($indonesiaTimeZone);
        $currentDateTimeString = $currentDateTime->format("Y-m-d H:i:s");

        $search_query = "SELECT insert_by FROM inventory_request WHERE request_id = '$request_id'";
        $search_result = $connect->query($search_query);
        $row = $search_result->fetch_assoc();
        $requestor_id = $row["insert_by"];

        $update_request_query = "UPDATE inventory_request SET last_status_request = 'INV-STA-003', update_by = '$employee_id', update_dt = '$currentDateTimeString' WHERE request_id = '$request_id'";
        $insert_log = "INSERT INTO inventory_request_log (request_id, action, action_by, action_dt) VALUES ('$request_id', 'Permintaan telah disetujui oleh general manager dan sedang dalam proses lebih lanjut', '$employee_id', '$currentDateTimeString')";
        if(mysqli_query($connect, $update_request_query) && mysqli_query($connect, $insert_log)){
            $send_notif_query = "INSERT INTO notification_alert (id, sender, receiver, title, message, send_date) VALUES (UUID(), '0000000015', '$requestor_id', 'Persetujuan Inventaris Baru', 'Permohonan inventaris anda telah disetujui oleh general manager dan sedang dalam proses tindak lanjut.', '$currentDateTimeString');";

            if(mysqli_query($connect, $send_notif_query)){
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
                        "message" => "Error: Unable to insert notification data - " . mysqli_error($connect)
                    )
                );
            }
        } else {
            http_response_code(404);
            echo json_encode(
                array(
                    "StatusCode" => 400,
                    'Status' => 'Error',
                     "message" => "Error: Unable to update inventory data - " . mysqli_error($connect)
                )
            );
        } 
    } else if ($action == '7'){
        $request_id = $_POST['request_id'];
        $employee_id = $_POST['employee_id'];
        $reject_reason = $_POST['reject_reason'];
        $currentDateTime = new DateTime();
        $indonesiaTimeZone = new DateTimeZone('Asia/Jakarta');
        $currentDateTime->setTimezone($indonesiaTimeZone);
        $currentDateTimeString = $currentDateTime->format("Y-m-d H:i:s");
        
        $search_query = "SELECT insert_by FROM inventory_request WHERE request_id = '$request_id'";
        $search_result = $connect->query($search_query);
        $row = $search_result->fetch_assoc();
        $requestor_id = $row["insert_by"];

        $update_request_query = "UPDATE inventory_request SET reject_reason = '$reject_reason', last_status_request = 'INV-STA-005', update_by = '$employee_id', update_dt = '$currentDateTimeString' WHERE request_id = '$request_id'";
        $insert_log = "INSERT INTO inventory_request_log (request_id, action, action_by, action_dt) VALUES ('$request_id', 'Permintaan telah ditolak oleh general manager dengan alasan $reject_reason', '$employee_id', '$currentDateTimeString')";
        if(mysqli_query($connect, $update_request_query) && mysqli_query($connect, $insert_log)){
            $send_notif_query = "INSERT INTO notification_alert (id, sender, receiver, title, message, send_date) VALUES (UUID(), '0000000015', '$requestor_id', 'Penolakan Inventaris Baru', 'Mohon maaf, saat ini permintaan inventaris baru anda dengan nomor permintaan $request_id ditolak dengan alasan $reject_reason. Untuk pemeriksaan lebih detail silahkan periksa melalui menu inventaris', '$currentDateTimeString');";

            if(mysqli_query($connect, $send_notif_query)){
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
                        "message" => "Error: Unable to insert notification data - " . mysqli_error($connect)
                    )
                );
            }
        } else {
            http_response_code(404);
            echo json_encode(
                array(
                    "StatusCode" => 400,
                    'Status' => 'Error',
                     "message" => "Error: Unable to update inventory data - " . mysqli_error($connect)
                )
            );
        }    

    //add new inventory
    } else if ($action == '8'){
        $inventory_name = $_POST['inventory_name'];
        $inventory_category = $_POST['inventory_category'];
        $inventory_id = $_POST['inventory_id'];
        $purchase_date = $_POST['purchase_date'];
        $warranty_date = $_POST['warranty_date'];
        $inventory_condition = $_POST['inventory_condition'];
        $assigned_to = $_POST['assigned_to'];
        $inventory_location = $_POST['inventory_location'];
        $purchase_method = $_POST['purchase_method'];
        $installment_period = $_POST['installment_period'];
        $due_date = $_POST['due_date'];
        $installment_price = $_POST['installment_price'];
        $purchase_price = $_POST['purchase_price'];
        $supplier_name = $_POST['supplier_name'];
        $inventory_status = $_POST['inventory_status'];
        $inventory_notes = $_POST['inventory_notes'];
        $hrd_employee_id = $_POST['hrd_employee_id'];
        $currentDateTime = new DateTime();
        $indonesiaTimeZone = new DateTimeZone('Asia/Jakarta');
        $currentDateTime->setTimezone($indonesiaTimeZone);
        $currentDateTimeString = $currentDateTime->format("Y-m-d H:i:s");
        
        $query = "INSERT INTO inventory (inventory_name, inventory_category, inventory_id, purchase_date, warranty_date, inventory_condition, assigned_to, inventory_location, purchase_method, installment_period, due_date, installment_price, purchase_price, supplier_name, inventory_status, inventory_notes, insert_by, insert_dt) VALUES ('$inventory_name', '$inventory_category', '$inventory_id', '$purchase_date', '$warranty_date', '$inventory_condition', '$assigned_to', '$inventory_location', '$purchase_method', '$installment_period', '$due_date', '$installment_price', '$purchase_price', '$supplier_name', '$inventory_status', '$inventory_notes', '$hrd_employee_id', '$currentDateTimeString');";
        
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
            http_response_code(404);
            echo json_encode(
                array(
                    "StatusCode" => 400,
                    'Status' => 'Error',
                     "message" => "Error: Unable to update inventory data - " . mysqli_error($connect)
                )
            );
        }
    } else if ($action == '9'){
        $new_status = 'IVN-STS-001';
        $assigned_to = $_POST['assigned_to'];
        $employee_id = $_POST['employee_id'];
        $inventory_id = $_POST['inventory_id'];
        $assigned_to_name = $_POST['assigned_to_name'];
        $request_id = $_POST['request_id'];
        $new_req_status = 'INV-STA-007';
        $currentDateTime = new DateTime();
        $indonesiaTimeZone = new DateTimeZone('Asia/Jakarta');
        $currentDateTime->setTimezone($indonesiaTimeZone);
        $currentDateTimeString = $currentDateTime->format("Y-m-d H:i:s");

        $query_one = "UPDATE inventory SET assigned_to = '$assigned_to', inventory_status = '$new_status', update_by = '$employee_id', update_dt = '$currentDateTimeString' WHERE inventory_id = '$inventory_id'";
        $query_two = "INSERT INTO inventory_log (inventory_id, action, action_by, action_dt) VALUES ('$inventory_id', 'Asset dengan ID $inventory_id telah diberikan kepada $assigned_to_name', '$employee_id','$currentDateTimeString')";
        $query_three = "UPDATE inventory_request SET last_status_request = '$new_req_status', update_by = '$employee_id', update_dt = '$currentDateTimeString' WHERE request_id = '$request_id'";
        $query_four = "INSERT INTO inventory_request_log (request_id, action, action_by, action_dt) VALUES ('$request_id', 'Asset inventaris telah diberikan kepada $assigned_to_name pada tanggal $currentDateTimeString dengan kondisi baik.', '$employee_id', '$currentDateTimeString')";
        $query_five = "INSERT INTO notification_alert (id, sender, receiver, title, message, send_date) VALUES (UUID(), '0000000015' , '$assigned_to', 'Penyerahan Asset', 'Selamat permohonan asset inventaris anda telah disetujui dan telah diberikan pada $currentDateTimeString. Gunakan dengan baik dan bijaksana untuk asset perusahaan', '$currentDateTimeString')";

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
            http_response_code(404);
            echo json_encode(
                array(
                    "StatusCode" => 404,
                    'Status' => 'Error',
                    "message" => "Error: Unable to update inventory data - " . mysqli_error($connect)
                )
            );
        }
    } else if ($action == '10'){
        $requestor_id = $_POST['requestor_id'];
        $inventory_id = $_POST['inventory_id'];
        $inventory_status = 'IVN-STS-003';
        $currentDateTime = new DateTime();
        $indonesiaTimeZone = new DateTimeZone('Asia/Jakarta');
        $currentDateTime->setTimezone($indonesiaTimeZone);
        $currentDateTimeString = $currentDateTime->format("Y-m-d H:i:s");

        $query_one = "UPDATE inventory SET inventory_status = '$inventory_status', update_by = '$requestor_id', update_dt = '$currentDateTimeString' WHERE inventory_id = '$inventory_id' ";
        $query_two = "INSERT INTO inventory_log (inventory_id, action, action_by, action_dt) VALUES ('$inventory_id', 'Asset inventaris sedang dalam perbaikan dan telah diajukan oleh $requestor_id pada $currentDateTimeString', '$requestor_id', '$currentDateTimeString')";

        if(mysqli_query($connect, $query_one) && mysqli_query($connect, $query_two)){
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
                    "StatusCode" => 404,
                    'Status' => 'Error',
                    "message" => "Error: Unable to update inventory data - " . mysqli_error($connect)
                )
            );
        }
    } else if ($action == '11'){
        $requestor_id = $_POST['requestor_id'];
        $inventory_id = $_POST['inventory_id'];
        $inventory_status = 'IVN-STS-002';
        $currentDateTime = new DateTime();
        $indonesiaTimeZone = new DateTimeZone('Asia/Jakarta');
        $currentDateTime->setTimezone($indonesiaTimeZone);
        $currentDateTimeString = $currentDateTime->format("Y-m-d H:i:s");

        $query_one = "UPDATE inventory SET inventory_status = '$inventory_status', update_by = '$requestor_id', update_dt = '$currentDateTimeString' WHERE inventory_id = '$inventory_id' ";
        $query_two = "INSERT INTO inventory_log (inventory_id, action, action_by, action_dt) VALUES ('$inventory_id', 'Asset inventaris telah dinon-aktifkan oleh $requestor_id pada $currentDateTimeString', '$requestor_id', '$currentDateTimeString')";

        if(mysqli_query($connect, $query_one) && mysqli_query($connect, $query_two)){
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
                    "StatusCode" => 404,
                    'Status' => 'Error',
                    "message" => "Error: Unable to update inventory data - " . mysqli_error($connect)
                )
            );
        }
    } else if ($action == '12'){
        $requestor_id = $_POST['requestor_id'];
        $inventory_id = $_POST['inventory_id'];
        $inventory_status = 'IVN-STS-002';
        $currentDateTime = new DateTime();
        $indonesiaTimeZone = new DateTimeZone('Asia/Jakarta');
        $currentDateTime->setTimezone($indonesiaTimeZone);
        $currentDateTimeString = $currentDateTime->format("Y-m-d H:i:s");

        $query_one = "UPDATE inventory SET assigned_to = '0000000026', inventory_status = '$inventory_status', update_by = '$requestor_id', update_dt = '$currentDateTimeString' WHERE inventory_id = '$inventory_id' ";
        $query_two = "INSERT INTO inventory_log (inventory_id, action, action_by, action_dt) VALUES ('$inventory_id', 'Asset inventaris telah dikembalikan ke perusahaan dan telah diperiksa oleh $requestor_id pada $currentDateTimeString', '$requestor_id', '$currentDateTimeString')";

        if(mysqli_query($connect, $query_one) && mysqli_query($connect, $query_two)){
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
                    "StatusCode" => 404,
                    'Status' => 'Error',
                    "message" => "Error: Unable to update inventory data - " . mysqli_error($connect)
                )
            );
        }
    } else if ($action == '13'){
        $requestor_id = $_POST['requestor_id'];
        $inventory_id = $_POST['inventory_id'];
        $inventory_status = 'IVN-STS-004';
        $currentDateTime = new DateTime();
        $indonesiaTimeZone = new DateTimeZone('Asia/Jakarta');
        $currentDateTime->setTimezone($indonesiaTimeZone);
        $currentDateTimeString = $currentDateTime->format("Y-m-d H:i:s");

        $query_one = "UPDATE inventory SET inventory_status = '$inventory_status', update_by = '$requestor_id', update_dt = '$currentDateTimeString' WHERE inventory_id = '$inventory_id' ";
        $query_two = "INSERT INTO inventory_log (inventory_id, action, action_by, action_dt) VALUES ('$inventory_id', 'Asset inventaris rusak dan telah diajukan oleh $requestor_id pada $currentDateTimeString', '$requestor_id', '$currentDateTimeString')";

        if(mysqli_query($connect, $query_one) && mysqli_query($connect, $query_two)){
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
                    "StatusCode" => 404,
                    'Status' => 'Error',
                    "message" => "Error: Unable to update inventory data - " . mysqli_error($connect)
                )
            );
        }
    } else if ($action == '14'){
        $new_status = 'IVN-STS-001';
        $assigned_to = $_POST['assigned_to'];
        $employee_id = $_POST['employee_id'];
        $inventory_id = $_POST['inventory_id'];
        $assigned_to_name = $_POST['assigned_to_name'];
        $currentDateTime = new DateTime();
        $indonesiaTimeZone = new DateTimeZone('Asia/Jakarta');
        $currentDateTime->setTimezone($indonesiaTimeZone);
        $currentDateTimeString = $currentDateTime->format("Y-m-d H:i:s");

        $query_one = "UPDATE inventory SET assigned_to = '$assigned_to', inventory_status = '$new_status', update_by = '$employee_id', update_dt = '$currentDateTimeString' WHERE inventory_id = '$inventory_id'";
        $query_two = "INSERT INTO inventory_log (inventory_id, action, action_by, action_dt) VALUES ('$inventory_id', 'Asset dengan ID $inventory_id telah diberikan kepada $assigned_to_name', '$employee_id','$currentDateTimeString')";
        $query_five = "INSERT INTO notification_alert (id, sender, receiver, title, message, send_date) VALUES (UUID(), '0000000015' , '$assigned_to', 'Penyerahan Asset', 'Selamat permohonan asset inventaris anda telah disetujui dan telah diberikan pada $currentDateTimeString. Gunakan dengan baik dan bijaksana untuk asset perusahaan', '$currentDateTimeString')";

        if(mysqli_query($connect, $query_one) && mysqli_query($connect, $query_two) && mysqli_query($connect, $query_five)){
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
                    "StatusCode" => 404,
                    'Status' => 'Error',
                    "message" => "Error: Unable to update inventory data - " . mysqli_error($connect)
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