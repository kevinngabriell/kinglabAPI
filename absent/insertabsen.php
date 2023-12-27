<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = $_POST['employee_id'];
    $company_id = $_POST['company_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    $absence_type = $_POST['absence_type'];

    if ($absence_type == "ABSENCETYPE-001") {
        $query = "SELECT In_Time FROM company_settings WHERE company_id = '$company_id'";
        $result = mysqli_query($connect, $query);

        if ($row = mysqli_fetch_assoc($result)) {
            $inTime = $row['In_Time'];
            $presence_type = (strtotime($time) > strtotime($inTime)) ? "PRESENCE004" : "PRESENCE001";
        } else {
            http_response_code(500);
            echo json_encode(array(
                "StatusCode" => 500,
                'Status' => 'Error',
                "message" => "Error: Unable to retrieve in time from company settings"
            ));
            exit;
        }
    } else if ($absence_type == "ABSENCETYPE-002") {
        $query = "SELECT Out_Time FROM company_settings WHERE company_id = '$company_id'";
        $result = mysqli_query($connect, $query);

        if ($row = mysqli_fetch_assoc($result)) {
            $outTime = $row['Out_Time'];
            $presence_type = (strtotime($time) > strtotime("+1 hour", strtotime($outTime))) ? "PRESENCE005" :
                ((strtotime($time) > strtotime($outTime) && strtotime($time) <= strtotime("+1 hour", strtotime($outTime))) ? "PRESENCE001" : "PRESENCE006");
        } else {
            http_response_code(500);
            echo json_encode(array(
                "StatusCode" => 500,
                'Status' => 'Error',
                "message" => "Error: Unable to retrieve out time from company settings"
            ));
            exit;
        }
    }

    $absence_id = uniqid('', true) . bin2hex(random_bytes(4));
    $photo = base64_decode($_POST['photo']);

    $jakartaTimezone = new DateTimeZone('Asia/Jakarta');
    $jakartaDatetime = new DateTime('now', $jakartaTimezone);
    $insertDatetime = $jakartaDatetime->format('Y-m-d H:i:s');

    $query = "INSERT INTO `absence_log` 
        (`employee_id`, `date`, `time`, `location`, `absence_id`, `absence_type`, `presence_type`, `photo`, `insert_datetime`) 
        VALUES ('$employee_id', '$date', '$time', '$location', '$absence_id', '$absence_type', '$presence_type', ?, '$insertDatetime');";

    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, 's', $photo);

    if (mysqli_stmt_execute($stmt)) {
        http_response_code(200);
        echo json_encode(array(
            "StatusCode" => 200,
            'Status' => 'Success',
            "message" => "Success: Data inserted successfully"
        ));
    } else {
        http_response_code(400);
        echo json_encode(array(
            "StatusCode" => 400,
            'Status' => 'Error',
            "message" => "Error: Unable to insert data - " . mysqli_error($connect)
        ));
    }
    mysqli_stmt_close($stmt);
} else {
    http_response_code(404);
    echo json_encode(array(
        "StatusCode" => 404,
        'Status' => 'Error',
        "message" => "Error: Invalid method. Only POST requests are allowed."
    ));
}

mysqli_close($connect);

?>