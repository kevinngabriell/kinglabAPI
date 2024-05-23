<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $applicant_id = $_POST["applicant_id"];
    $status_name = $_POST['status_name'];
    $action = $_POST['action'];
    $employee_id = $_POST['employee_id'];

    $currentDateTime = new DateTime();
    $indonesiaTimeZone = new DateTimeZone('Asia/Jakarta');
    $currentDateTime->setTimezone($indonesiaTimeZone);
    $currentDateTimeString = $currentDateTime->format("Y-m-d H:i:s");

    if($status_name == 'Surat lamaran telah diterima' && $action == '1'){
        $query = "UPDATE job_applicant SET status = 'NEW-STATUS-007' WHERE id_applicant = '$applicant_id';";
        $job_applicant_history = "INSERT INTO job_applicant_history (id_applicant, action, status, insert_dt, insert_by) VALUES ('$applicant_id', 'Peserta lulus pada tahap administrasi dan akan dilanjutkan proses wawancara pertama', 'NEW-STATUS-007', '$currentDateTimeString', '$employee_id');";

        if(mysqli_query($connect, $query) && mysqli_query($connect, $job_applicant_history)){
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

    } else if ($action == '0'){
        $query = "UPDATE job_applicant SET status = 'NEW-STATUS-011' WHERE id_applicant = '$applicant_id';";
        $job_applicant_history = "INSERT INTO job_applicant_history (id_applicant, action, status, insert_dt, insert_by) VALUES ('$applicant_id', 'Peserta tidak lulus pada tahap administrasi dan dinyatakan gugur', 'NEW-STATUS-011', '$currentDateTimeString', '$employee_id');";

        if(mysqli_query($connect, $query) && mysqli_query($connect, $job_applicant_history)){
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
        $query = "UPDATE job_applicant SET status = 'NEW-STATUS-008' WHERE id_applicant = '$applicant_id';";
        $job_applicant_history = "INSERT INTO job_applicant_history (id_applicant, action, status, insert_dt, insert_by) VALUES ('$applicant_id', 'Peserta lulus tahap interview pertama dan menunggu jadwal interview kedua', 'NEW-STATUS-008', '$currentDateTimeString', '$employee_id');";
        
        if(mysqli_query($connect, $query) && mysqli_query($connect, $job_applicant_history)){
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