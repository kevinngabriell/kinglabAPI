<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'];

    if($action == '1'){
        $employee_id = $_GET['employee_id'];

        $query_one = "SELECT COUNT(*) as myLoan FROM loan A1 WHERE A1.employee_id = '$employee_id';";
        $result_one = $connect->query($query_one);
        $pinjamanSaya = array();
        while($row_one = $result_one->fetch_assoc()){
            $pinjamanSaya[] = $row_one;
        }

        $query_two = "SELECT SUM(A1.loan_amount) as myTotalLoan FROM loan A1 WHERE A1.employee_id = '$employee_id';";
        $result_two = $connect->query($query_two);
        $totalPinjamanSaya = array();
        while($row_two = $result_two->fetch_assoc()){
            $totalPinjamanSaya[] = $row_two;
        }

        $query_three = "SELECT SUM(A1.loan_amount) as totalLoan FROM loan A1;";
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
                    'myLoan' => $pinjamanSaya[0]['myLoan'],
                    'myTotalLoan' => $totalPinjamanSaya[0]['myTotalLoan'],
                    'totalLoan' => $totalPinjaman[0]['totalLoan']
                ]
            )
        );


    } else if ($action == '2'){
        $employee_id = $_GET['employee_id'];

        $query = "SELECT A1.loan_id, A1.loan_amount, A1.loan_reason, A1.loan_topay, A3.status_name, A1.is_paid, A1.insert_by, A1.insert_dt, A2.employee_name, A4.department_name, A5.position_name
        FROM loan A1
        LEFT JOIN employee A2 ON A1.employee_id = A2.id
        LEFT JOIN loan_status A3 ON A1.status = A3.status_id
        LEFT JOIN department A4 ON A2.department_id = A4.department_id
        LEFT JOIN position_db A5 ON A2.position_id = A5.position_id
        WHERE A1.employee_id = '$employee_id'
        ORDER BY A1.insert_dt DESC;";

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

        $query = "SELECT A1.loan_id, A1.loan_amount, A1.loan_reason, A1.loan_topay, A3.status_name, A1.is_paid, A1.insert_by, A1.insert_dt, A2.employee_name, A4.department_name, A5.position_name
        FROM loan A1
        LEFT JOIN employee A2 ON A1.employee_id = A2.id
        LEFT JOIN loan_status A3 ON A1.status = A3.status_id
        LEFT JOIN department A4 ON A2.department_id = A4.department_id
        LEFT JOIN position_db A5 ON A2.position_id = A5.position_id
        ORDER BY A1.insert_dt DESC;";

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
        $loan_id = $_GET['loan_id'];

        $query = "SELECT A1.action, A1.action_dt, A2.employee_name
        FROM loan_log A1 
        LEFT JOIN employee A2 ON A1.action_by = A2.id
        WHERE A1.loan_id = '$loan_id';";

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
        $loan_id = $_GET['loan_id'];

        $query = "SELECT A2.employee_name, A1.action_dt
        FROM loan_log A1
        LEFT JOIN employee A2 ON A1.action_by = A2.id
        WHERE A1.action LIKE '%disetujui oleh HRD%' AND A1.loan_id = '$loan_id';";

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
        $loan_id = $_GET['loan_id'];

        $query = "SELECT A2.employee_name, A1.action_dt
        FROM loan_log A1
        LEFT JOIN employee A2 ON A1.action_by = A2.id
        WHERE A1.action LIKE '%diterima oleh manager%' AND A1.loan_id = '$loan_id';";

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
        $id_pinjaman = $_GET['id_pinjaman'];
        
        $order_query = "SELECT amount, transaction_date, transaction FROM loan_transaction WHERE loan_id = ? ORDER BY transaction_date";
        $stmt_order = mysqli_prepare($connect, $order_query);
        mysqli_stmt_bind_param($stmt_order, "s", $id_pinjaman);
        mysqli_stmt_execute($stmt_order);
        $result_order = mysqli_stmt_get_result($stmt_order);
    
        // Fetch and return the ordered transactions
        $ordered_transactions = array();
        while ($row = mysqli_fetch_assoc($result_order)) {
            $ordered_transactions[] = $row;
        }
    
        echo json_encode(array("StatusCode" => 200, "Status" => "Success", "Data" => $ordered_transactions));
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