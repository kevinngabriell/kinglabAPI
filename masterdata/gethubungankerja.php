<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM hubungan_kerja_db";
    $query = mysqli_query($connect, $sql);

    $result = array();
    while ($row = mysqli_fetch_array($query)) {
        array_push(
            $result,
            array(
                'hubungan_kerja_id' => $row['hubungan_kerja_id'],
                'hubungan_kerja_name' => $row['hubungan_kerja_name']
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