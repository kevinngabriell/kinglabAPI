<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id_applicant = $_GET['id_applicant'];

    $query = "SELECT interview_date, interview_time, interview_location, interview_date_2, interview_time_2, interview_location_2
    FROM job_applicant
    WHERE id_applicant = '$id_applicant';";
    $result = $connect->query($query);

    if($result->num_rows > 0){
        $jatahCuti = array();

        while($row = $result->fetch_assoc()){
            $jatahCuti[] = $row;
        }

        http_response_code(200);
        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status' => 'Success',
                'Data' => $jatahCuti
            )
        );
    } else{
        http_response_code(400);
        echo json_encode(
            array(
                'StatusCode' => 400,
                'Status' => 'Not Found',
                "message" => "No found"
            )
        );
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