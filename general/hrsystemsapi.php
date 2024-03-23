<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'];

    // For Department List
    if($action == '1'){
        $query = "SELECT * FROM department;";

        $result = $connect->query($query);

        if($result->num_rows > 0){

            $jumlahCuti = array();

            while($row = $result->fetch_assoc()){
                $jumlahCuti[] = $row;
            }

            http_response_code(200);
            echo json_encode(
                array(
                    'StatusCode' => 200,
                    'Status' => 'Success',
                    'Data' => $jumlahCuti
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

    //For Position List
    } else if ($action == '2'){
        $query = "SELECT * FROM position_db;";

        $result = $connect->query($query);

        if($result->num_rows > 0){

            $jumlahCuti = array();

            while($row = $result->fetch_assoc()){
                $jumlahCuti[] = $row;
            }

            http_response_code(200);
            echo json_encode(
                array(
                    'StatusCode' => 200,
                    'Status' => 'Success',
                    'Data' => $jumlahCuti
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
    }

} else {
    http_response_code(405);
    echo json_encode([
        "StatusCode" => 405,
        'Status' => 'Error',
        "message" => "Error: Invalid method. Only GET requests are allowed."
    ]);
}