<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

// Display error message
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $currentDateTime = new DateTime();
    $indonesiaTimeZone = new DateTimeZone('Asia/Jakarta');
    $currentDateTime->setTimezone($indonesiaTimeZone);
    $currentDateTimeString = $currentDateTime->format("Y-m-d H:i:s");

    if($action == '1'){
        $employee_id = $_POST['employee_id'];
        $amount = $_POST['amount'];
        $kasbon_date = $_POST['kasbon_date'];
        $keterangan = $_POST['keterangan'];
        $hrd = $_POST['hrd'];

        $query_one = "INSERT INTO kasbon(id_kasbon, employee_id, kasbon_date, kasbon_amount, kasbon_exp, is_paid,insert_by, insert_dt) VALUES 
        (UUID(),'$employee_id','$kasbon_date','$amount','$keterangan', 0,'$hrd','$currentDateTimeString');";

        if(mysqli_query($connect, $query_one)){
            $search_query = "SELECT id_kasbon FROM kasbon ORDER BY insert_dt DESC LIMIT 1";
            $result_last_id= $connect->query($search_query);
            $row = $result_last_id->fetch_assoc();
            $last_id = $row["id_kasbon"];

            $query_two = "INSERT INTO kasbon_transaction(id_kasbon, transaction_type, amount, insert_by, insert_dt) VALUES 
            ('$last_id', 0,'$amount','$hrd','$currentDateTimeString')";
            $query_three = "INSERT INTO kasbon_log(id_kasbon, action, action_by, action_dt) VALUES 
            ('$last_id','Input kasbon telah berhasil dilakukan','$hrd','$currentDateTimeString')";

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
                    "message" => "Error: Unable to insert kasbon data - " . mysqli_error($connect)
                )
            );
        }
    } else if ($action == '2'){
        $id_kasbon = $_POST['id_kasbon'];
        $amount = $_POST['amount'];
        $insert_by = $_POST['insert_by'];

        // INSERT INTO query
        $insert_query = "INSERT INTO kasbon_transaction (id_kasbon, transaction_type, amount, insert_by, insert_dt) 
                        VALUES ('$id_kasbon', 1, $amount, '$insert_by', '$currentDateTimeString')";

        // Perform the insertion and check if successful
        if(mysqli_query($connect, $insert_query)){ 
            // SELECT query to calculate total paid amount
            $total_paid_query = "SELECT SUM(amount) AS total_paid FROM kasbon_transaction 
                                WHERE id_kasbon = '$id_kasbon' AND transaction_type = 1";
            $result= $connect->query($total_paid_query);
            $row = $result->fetch_assoc();
            $total_paid = $row['total_paid'];

            // SELECT query to retrieve the total borrowed amount
            $borrowed_query = "SELECT kasbon_amount FROM kasbon WHERE id_kasbon = '$id_kasbon'";
            $result_borrowed= $connect->query($borrowed_query);
            $row_borrowed = $result_borrowed->fetch_assoc();
            $total_borrowed = $row_borrowed['kasbon_amount'];
            
            echo $total_paid;
            echo $total_borrowed;

            // Check if the total paid is enough to mark the kasbon as paid off
            if ($total_paid >= $total_borrowed) {
                $update_status_query = "UPDATE kasbon SET is_paid = 1 WHERE id_kasbon = '$id_kasbon'";
                if(mysqli_query($connect, $update_status_query)){ 
                    echo json_encode(array("StatusCode" => 200, "Status" => "Success", "Message" => "Kasbon transaction inserted successfully"));
                }
                
            }
            
            echo json_encode(array("StatusCode" => 200, "Status" => "Success", "Message" => "Kasbon transaction inserted successfully"));
            
        } else {
            // Error handling if insertion fails
            http_response_code(400);
            echo json_encode(
                array(
                    "StatusCode" => 400,
                    'Status' => 'Error',
                    "message" => "Error: Unable to insert kasbon data - " . mysqli_error($connect)
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