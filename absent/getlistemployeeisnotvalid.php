<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    $sql = "SELECT A2.employee_name, A1.date, A1.time, A1.location, A3.presence_type_name, A1.is_valid, A1.absence_id, A1.photo
    FROM absence_log A1
    JOIN employee A2 ON A2.id = A1.employee_id
    JOIN presence_type A3 ON A3.id_presence_type = A1.presence_type
    WHERE (A1.is_valid IS NULL OR A1.is_valid = '0')
    ORDER BY A1.date ASC;";
    $query = mysqli_query($connect, $sql);

    $result = array();
    while ($row = mysqli_fetch_array($query)) {
        $photoData = $row['photo'];
    
        // Encode the BLOB data as a base64 string
        $encodedPhoto = base64_encode($photoData);
    
        array_push(
            $result,
            array(
                'absence_id' => $row['absence_id'],
                'employee_name' => $row['employee_name'],
                'date' => $row['date'],
                'time' => $row['time'],
                'location' => $row['location'],
                'presence_type_name' => $row['presence_type_name'],
                'is_valid' => $row['is_valid'],
                'photo' => $encodedPhoto // Store the base64-encoded image string
            )
        );
    }


    if ($result) {
        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status' => 'Success',
                'Data' => $result
            )
        );
    } else {
        http_response_code(400);
        echo json_encode(
            array(
                'StatusCode' => 400,
                'Status' => 'Error Bad Request, Result not found !'
            )
        );
    }
} else {
    http_response_code(405);
    echo json_encode(
        array(
            'StatusCode' => 405,
            'Status' => 'Error',
            'Message' => 'Please check your method request'
        )
    );
}

?>