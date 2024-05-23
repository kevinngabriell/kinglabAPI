<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'];

    if($action == '1'){
        $employee_id = $_GET['employee_id'];

        $query_one = "SELECT COUNT(id_kasbon) as active_kasbon FROM kasbon;";
        $result_one = $connect->query($query_one);
        $pinjamanSaya = array();
        while($row_one = $result_one->fetch_assoc()){
            $pinjamanSaya[] = $row_one;
        }

        $query_two = "SELECT SUM(kasbon_amount) as jumlah_kasbon FROM kasbon;";
        $result_two = $connect->query($query_two);
        $totalPinjamanSaya = array();
        while($row_two = $result_two->fetch_assoc()){
            $totalPinjamanSaya[] = $row_two;
        }

        http_response_code(200);
        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status' => 'Success',
                'Data' => [
                    'active_kasbon' => $pinjamanSaya[0]['active_kasbon'],
                    'jumlah_kasbon' => $totalPinjamanSaya[0]['jumlah_kasbon']
                ]
            )
        );
    } else if ($action == '2'){
        $query = "SELECT A1.id_kasbon, A1.kasbon_date, A1.kasbon_amount, A1.kasbon_exp, A2.employee_name as karyawan, A3.employee_name as hrd, A1.insert_dt, A1.is_paid FROM kasbon A1 LEFT JOIN employee A2 ON A1.employee_id = A2.id LEFT JOIN employee A3 ON A1.insert_by = A3.id;";
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
        $id_kasbon = $_GET['id_kasbon'];
        
        $order_query = "SELECT id_kasbon, transaction_type, amount, insert_by, insert_dt FROM kasbon_transaction 
                    WHERE id_kasbon = ? ORDER BY insert_dt";
        $stmt_order = mysqli_prepare($connect, $order_query);
        mysqli_stmt_bind_param($stmt_order, "s", $id_kasbon);
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