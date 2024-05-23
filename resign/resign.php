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
        $status_name = $_POST['status_name'];
    
        $query = "INSERT INTO resign_status (status_id, status_name) VALUES (UUID(), '$status_name');";
    
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
        $employee_id = $_POST['employee_id'];
        $effective_date = $_POST['effective_date'];
        $resign_reason = $_POST['resign_reason'];
        $status = "dd332781-f3d4-11ee-a";

        $query_one = "INSERT INTO resign(resign_id, employee_id, effective_date, resign_reason, status, insert_by, insert_dt) VALUES (UUID(),'$employee_id','$effective_date','$resign_reason','$status','$employee_id','$currentDateTimeString')";
        //dd332781-f3d4-11ee-a

        if(mysqli_query($connect, $query_one)){
            $search_query = "SELECT resign_id FROM resign ORDER BY insert_dt DESC LIMIT 1";
            $result_last_id= $connect->query($search_query);
            $row = $result_last_id->fetch_assoc();
            $last_id = $row["resign_id"];

            $query_two = "INSERT INTO resign_log(resign_id, action, action_by, action_dt) VALUES 
            ('$last_id','Pengajuan pemunduran diri anda telah berhasil diajukan kepada pihak HRD','$employee_id','$currentDateTimeString')";

            if(mysqli_query($connect, $query_two)){
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
    } else if ($action == '3'){
        $employee_id = $_POST['employee_id'];
        $resign_id = $_POST['resign_id'];
        $status = "dfae49a8-f3d4-11ee-a";

        $query_one = " UPDATE resign SET status = '$status', update_by = '$employee_id', update_dt = '$currentDateTimeString' WHERE resign_id = '$resign_id'";
        //dd332781-f3d4-11ee-a

        if(mysqli_query($connect, $query_one)){

            $query_two = "INSERT INTO resign_log(resign_id, action, action_by, action_dt) VALUES 
            ('$resign_id','Pengajuan pemunduran diri anda telah disetujui oleh pihak HRD','$employee_id','$currentDateTimeString')";

            if(mysqli_query($connect, $query_two)){
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
?>