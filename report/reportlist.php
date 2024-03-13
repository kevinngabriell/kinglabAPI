<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $query = "SELECT * FROM report_type;";
    $result = $connect->query($query);

    $monthQuery = "SELECT * FROM month";
    $monthResult = $connect->query($monthQuery);

    $yearQuery = "SELECT * FROM year";
    $yearResult = $connect->query($yearQuery);

    $departmentQuery = "SELECT * FROM department where company_id = 'COM-HR-001'";
    $departmentResult = $connect->query($departmentQuery);

    if($result->num_rows > 0){

        $reportType = array();
        $monthList = array();
        $yearList = array();
        $departmentList = array();

        while($row = $result->fetch_assoc()){
            $reportType[] = $row;
        }

        while($monthRow = $monthResult->fetch_assoc()){
            $monthList[] = $monthRow;
        }

        while($yearRow = $yearResult->fetch_assoc()){
            $yearList[] = $yearRow;
        }

        while($departmentRow = $departmentResult->fetch_assoc()){
            $departmentList[] = $departmentRow;
        }

        http_response_code(200);
        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status' => 'Success',
                'Data' => [
                    'Report Type' => $reportType,
                    'Department' => $departmentList,
                    'Month List' => $monthList,
                    'Year List' => $yearList
                ]
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