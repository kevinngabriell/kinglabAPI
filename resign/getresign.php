<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'];

    if($action == '1'){
        $employee_id = $_GET['employee_id'];

        $query_one = "SELECT COUNT(inventory_id) as inventory FROM inventory WHERE assigned_to = '$employee_id';";
        $result_one = $connect->query($query_one);
        $pinjamanSaya = array();
        while($row_one = $result_one->fetch_assoc()){
            $pinjamanSaya[] = $row_one;
        }

        $query_two = "SELECT SUM(loan_amount) as totalloan FROM loan WHERE is_paid = 0 AND employee_id = '$employee_id' AND status = '601ddc2c-eb4c-11ee-a';";
        $result_two = $connect->query($query_two);
        $totalPinjamanSaya = array();
        while($row_two = $result_two->fetch_assoc()){
            $totalPinjamanSaya[] = $row_two;
        }

        $query_three = "SELECT SUM(kasbon_amount) as totalkasbon FROM kasbon WHERE is_paid = 0 AND employee_id = '$employee_id';";
        $result_three = $connect->query($query_three);
        $totalPinjaman = array();
        while($row_three = $result_three->fetch_assoc()){
            $totalPinjaman[] = $row_three;
        }

        http_response_code(200);
        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status' => 'Success',
                'Data' => [
                    'inventory' => $pinjamanSaya[0]['inventory'],
                    'totalloan' => $totalPinjamanSaya[0]['totalloan'],
                    'totalkasbon' => $totalPinjaman[0]['totalkasbon']
                ]
            )
        );
    } else if ($action == '2'){
        $query = "SELECT A2.employee_name, A1.effective_date, A1.resign_reason, A3.status_name, A1.insert_dt, A1.resign_id, A2.id
            FROM resign A1
            LEFT JOIN employee A2 ON A1.employee_id = A2.id
            LEFT JOIN resign_status A3 ON A1.status = A3.status_id;";

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
    } else if ($action == '3'){
        $employee_id = $_GET['employee_id'];
        
        $query = "SELECT A2.employee_name, A1.effective_date, A1.resign_reason, A3.status_name, A1.insert_dt, A1.resign_id,  A2.id
            FROM resign A1
            LEFT JOIN employee A2 ON A1.employee_id = A2.id
            LEFT JOIN resign_status A3 ON A1.status = A3.status_id
            WHERE A1.employee_id = '$employee_id';";

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
    http_response_code(404);
    echo json_encode(
        array(
            "StatusCode" => 404,
            'Status' => 'Error',
            "message" => "Error: Invalid method. Only POST requests are allowed."
        )
    );
}