<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $applicant_id = $_POST["applicant_id"];
    $action = $_POST['action'];
    $currentDateTime = new DateTime();
    $indonesiaTimeZone = new DateTimeZone('Asia/Jakarta');
    $currentDateTime->setTimezone($indonesiaTimeZone);
    $currentDateTimeString = $currentDateTime->format("Y-m-d H:i:s");
    
    //insert new interview
    if($action == '1'){
        $interview_date = $_POST['interview_date'];
        $interview_time = $_POST['interview_time'];
        $interview_location = $_POST['interview_location'];
        $employee_id = $_POST['employee_id'];

        $query = "UPDATE job_applicant SET status = 'NEW-STATUS-013', interview_date = '$interview_date', interview_time = '$interview_time', interview_location = '$interview_location'  WHERE id_applicant = '$applicant_id';";
        $job_applicant_history = "INSERT INTO job_applicant_history (id_applicant, action, status, insert_dt, insert_by) VALUES ('$applicant_id', 'Peserta telah dijadwalkan untuk interview tahap pertama', 'NEW-STATUS-013', '$$currentDateTimeString', '$employee_id');";    
        
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

    //insert interview result
    } else if($action == '2'){
        $result_one = $_POST['result_one'];
        $result_two = $_POST['result_two'];
        $result_three = $_POST['result_three'];
        $result_four = $_POST['result_four'];
        $result_five = $_POST['result_five'];
        $result_six = $_POST['result_six'];
        $result_seven = $_POST['result_seven'];
        $result_eight = $_POST['result_eight'];
        $result_nine = $_POST['result_nine'];
        $result_ten = $_POST['result_ten'];
        $notes = $_POST['notes'];

        $query_one = "INSERT INTO inteview (applicant_id, question, question_score, notes) VALUES ('$applicant_id', '1', '$result_one', NULL)";
        $query_two = "INSERT INTO inteview (applicant_id, question, question_score, notes) VALUES ('$applicant_id', '2', '$result_two', NULL)";
        $query_three = "INSERT INTO inteview (applicant_id, question, question_score, notes) VALUES ('$applicant_id', '3', '$result_three', NULL)";
        $query_four = "INSERT INTO inteview (applicant_id, question, question_score, notes) VALUES ('$applicant_id', '4', '$result_four', NULL)";
        $query_five = "INSERT INTO inteview (applicant_id, question, question_score, notes) VALUES ('$applicant_id', '5', '$result_five', NULL)";
        $query_six = "INSERT INTO inteview (applicant_id, question, question_score, notes) VALUES ('$applicant_id', '6', '$result_six', NULL)";
        $query_seven = "INSERT INTO inteview (applicant_id, question, question_score, notes) VALUES ('$applicant_id', '7', '$result_seven', NULL)";
        $query_eight = "INSERT INTO inteview (applicant_id, question, question_score, notes) VALUES ('$applicant_id', '8', '$result_eight', NULL)";
        $query_nine = "INSERT INTO inteview (applicant_id, question, question_score, notes) VALUES ('$applicant_id', '9', '$result_nine', NULL)";
        $query_ten = "INSERT INTO inteview (applicant_id, question, question_score, notes) VALUES ('$applicant_id', '10', '$result_ten', NULL)";
        $query_eleven = "INSERT INTO inteview (applicant_id, question, question_score, notes) VALUES ('$applicant_id', NULL, '$notes', NULL)";

        if(mysqli_query($connect, $query_one) && mysqli_query($connect, $query_two) && 
        mysqli_query($connect, $query_three) && mysqli_query($connect, $query_four) && 
        mysqli_query($connect, $query_five) && mysqli_query($connect, $query_six) && 
        mysqli_query($connect, $query_seven) && mysqli_query($connect, $query_eight) && 
        mysqli_query($connect, $query_nine) && mysqli_query($connect, $query_ten) && 
        mysqli_query($connect, $query_eleven)){
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
        $sec_notes = $_POST['sec_notes'];
        $query_one = "UPDATE interview SET second_notes = '$sec_notes' WHERE applicant_id = '$applicant_id'";

        if(mysqli_query($connect, $query_one)){
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
        $interview_date = $_POST['interview_date'];
        $interview_time = $_POST['interview_time'];
        $interview_location = $_POST['interview_location'];
        $employee_id = $_POST['employee_id'];

        $query = "UPDATE job_applicant SET status = 'NEW-STATUS-014', interview_date_2 = '$interview_date', interview_time_2 = '$interview_time', interview_location_2 = '$interview_location'  WHERE id_applicant = '$applicant_id';";
        $job_applicant_history = "INSERT INTO job_applicant_history (id_applicant, action, status, insert_dt, insert_by) VALUES ('$applicant_id', 'Peserta telah dijadwalkan untuk interview tahap kedua', 'NEW-STATUS-014', '$$currentDateTimeString', '$employee_id');";    
        
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
    } else if ($action == '5'){
        $employee_id = $_POST['employee_id'];

        $query = "UPDATE job_applicant SET status = 'NEW-STATUS-009' WHERE id_applicant = '$applicant_id';";
        $job_applicant_history = "INSERT INTO job_applicant_history (id_applicant, action, status, insert_dt, insert_by) VALUES ('$applicant_id', 'Peserta telah lulus tahap kedua wawancara', 'NEW-STATUS-009', '$$currentDateTimeString', '$employee_id');";    
        
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
    } else if ($action == '6'){
        $employee_id = $_POST['employee_id'];

        $query = "UPDATE job_applicant SET status = 'NEW-STATUS-010' WHERE id_applicant = '$applicant_id';";
        $job_applicant_history = "INSERT INTO job_applicant_history (id_applicant, action, status, insert_dt, insert_by) VALUES ('$applicant_id', 'Peserta telah diterima', 'NEW-STATUS-010', '$$currentDateTimeString', '$employee_id');";    
        
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