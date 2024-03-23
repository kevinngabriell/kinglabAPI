<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'];

    if($action == '1'){
        $query = "SELECT * FROM kotakab_db;";

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
    } else if ($action == '2'){
        $query = "SELECT * FROM businesstrip_duration;";

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
        $query = "SELECT * FROM position_db where position_id = 'POS-HR-027' OR position_id = 'POS-HR-028';";

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
    } else if ($action == '4'){
        $query = "SELECT * FROM businesstrip_payment;";

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
    } else if ($action == '5'){
        $query = "SELECT * FROM businesstrip_transport;";

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
    } else if ($action == '6'){
        $employee_id = $_GET['employee_id'];
        
        $query = "SELECT A1.businesstrip_id, A2.name as nama_kota, A3.duration_name, A1.reason, A1.team, A4.payment_name, A5.transport_name, A6.employee_name, A1.insert_dt, A7.status_name, A8.department_name
        FROM businesstrip A1
        LEFT JOIN kotakab_db A2 ON A1.city = A2.id
        LEFT JOIN businesstrip_duration A3 ON A1.duration = A3.duration_id
        LEFT JOIN businesstrip_payment A4 ON A1.payment = A4.payment_id
        LEFT JOIN businesstrip_transport A5 ON A1.transport = A5.transport_id
        LEFT JOIN employee A6 ON A1.insert_by = A6.id
        LEFT JOIN businesstrip_status A7 ON A1.status = A7.status_id
        LEFT JOIN department A8 ON A6.department_id = A8.department_id
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
    } else if ($action == '7'){
        
        $query = "SELECT A1.businesstrip_id, A2.name as nama_kota, A3.duration_name, A1.reason, A1.team, A4.payment_name, A5.transport_name, A6.employee_name, A1.insert_dt, A7.status_name, A8.department_name
        FROM businesstrip A1
        LEFT JOIN kotakab_db A2 ON A1.city = A2.id
        LEFT JOIN businesstrip_duration A3 ON A1.duration = A3.duration_id
        LEFT JOIN businesstrip_payment A4 ON A1.payment = A4.payment_id
        LEFT JOIN businesstrip_transport A5 ON A1.transport = A5.transport_id
        LEFT JOIN employee A6 ON A1.insert_by = A6.id
        LEFT JOIN businesstrip_status A7 ON A1.status = A7.status_id
        LEFT JOIN department A8 ON A6.department_id = A8.department_id;";

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
    } else if ($action == '8'){

        $businesstrip_id = $_GET['businesstrip_id'];
        
        $query = "SELECT A1.member_name
        FROM businesstrip_team A1
        WHERE A1.businesstrip_id = '$businesstrip_id';";

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
    } else if ($action == '9'){

        $businesstrip_id = $_GET['businesstrip_id'];
        
        $query = "SELECT A2.employee_name, A1.action, A1.action_dt
        FROM businesstrip_log A1
        LEFT JOIN employee A2 ON A1.action_by = A2.id
        WHERE A1.businesstrip_id = '$businesstrip_id';";

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