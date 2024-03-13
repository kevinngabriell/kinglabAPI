<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

$permission_id = $_GET['permission_id'];

$query = "SELECT attachment
          FROM permission_log
          WHERE id_permission = ?";

$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, 's', $permission_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $row['attachment'] = base64_encode($row['attachment']);
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