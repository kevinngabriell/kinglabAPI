<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $province_id = $_GET['provinsi'];

    //query
    $sql = "SELECT * FROM kotakab_db WHERE province_id = '$province_id';";
    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
        $kotakab = array();

        while ($row = $result->fetch_assoc()) {
            $kotakab[] = $row;
        }

        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status' => 'Success',
                'Data' => $kotakab
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