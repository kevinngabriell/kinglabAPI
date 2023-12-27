<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

$employeeId = $_GET['employee_id'];

$query = "SELECT A1.absence_id, A1.date, A1.time, A1.location, A1.insert_datetime, A2.presence_type_name, A3.id_absence_type, A3.absence_type_name, A4.employee_name, A1.photo
          FROM absence_log A1 
          JOIN presence_type A2 ON A1.presence_type = A2.id_presence_type 
          JOIN absence_type A3 ON A1.absence_type = A3.id_absence_type 
          JOIN employee A4 ON A1.employee_id = A4.id 
          WHERE A1.employee_id = ?";

$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, 's', $employeeId);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $row['photo'] = base64_encode($row['photo']);
            $data[] = $row;
        }
        echo json_encode($data);
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
    echo 'Error: Unable to execute query - ' . mysqli_error($connect);
}

mysqli_stmt_close($stmt);
mysqli_close($connect);

?>