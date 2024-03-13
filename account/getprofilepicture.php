<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

$employeeId = $_GET['employee_id'];

$query = "SELECT employee_image
          FROM employee
          WHERE id = ?";

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