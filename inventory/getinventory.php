<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'];

    if($action == '1'){
        $query = "SELECT * FROM inventory_category;";

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
        $sql = "SELECT * FROM inventory_condition";
        $query = mysqli_query($connect, $sql);

        $result = array();
        while ($row = mysqli_fetch_array($query)) {
            array_push(
                $result,
                array(
                    'condition_id' => $row['condition_id'],
                    'condition_name' => $row['condition_name']
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
    } else if ($action == '3'){
        $query = "SELECT * FROM inventory_payment_method;";

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
        $query = "SELECT * FROM inventory_installment;";

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
        $query = "SELECT * FROM inventory_status;";

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
        $query = "SELECT A1.inventory_id, A1.inventory_name, A2.status_name, A3.inventory_category_name, purchase_date, warranty_date, A4.condition_name, A5.employee_name, A1.inventory_location, A6.payment_method, A7.inventory_installment_name, A1.due_date, A1.installment_price, A1.purchase_price, A1.supplier_name, A8.status_name, A1.inventory_notes
        FROM inventory A1
        LEFT JOIN inventory_status A2 ON A1.inventory_status = A2.status_id
        LEFT JOIN inventory_category A3 ON A1.inventory_category = A3.id_inventory_category
        LEFT JOIN inventory_condition A4 ON A1.inventory_condition = A4.condition_id
        LEFT JOIN employee A5 ON A1.assigned_to = A5.id
        LEFT JOIN inventory_payment_method A6 ON A1.purchase_method = A6.id_payment_method
        LEFT JOIN inventory_installment A7 ON A1.installment_period = A7.id_inventory_installment
        LEFT JOIN inventory_status A8 ON A1.inventory_status = A8.status_id;";

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
        $employee_id = $_GET['employee_id'];

        $query = "SELECT A1.inventory_name, A1.inventory_id, A2.inventory_category_name, A3.status_name
        FROM inventory A1
        LEFT JOIN inventory_category A2 ON A1.inventory_category = A2.id_inventory_category
        LEFT JOIN inventory_status A3 ON A1.inventory_status = A3.status_id
        WHERE A1.assigned_to = '$employee_id';";

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

        $query = "SELECT A1.inventory_name, A1.inventory_id, A2.inventory_category_name, A3.status_name
        FROM inventory A1
        LEFT JOIN inventory_category A2 ON A1.inventory_category = A2.id_inventory_category
        LEFT JOIN inventory_status A3 ON A1.inventory_status = A3.status_id;";

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
        $inventory_id = $_GET['inventory_id'];

        $query = "SELECT A1.inventory_name, A1.inventory_id, A2.inventory_category_name, A1.purchase_date, A1.warranty_date, A4.condition_name, A5.employee_name, A1.inventory_location, A6.payment_method, A7.inventory_installment_name, A1.due_date, A1.installment_price, A1.purchase_price, A1.supplier_name, A3.status_name, A1.inventory_notes
        FROM inventory A1
        LEFT JOIN inventory_category A2 ON A1.inventory_category = A2.id_inventory_category
        LEFT JOIN inventory_status A3 ON A1.inventory_status = A3.status_id
        LEFT JOIN inventory_condition A4 ON A1.inventory_condition = A4.condition_id
        LEFT JOIN employee A5 ON A1.assigned_to = A5.id
        LEFT JOIN inventory_payment_method A6 ON A1.purchase_method = A6.id_payment_method
        LEFT JOIN inventory_installment A7 ON A1.installment_period = A7.id_inventory_installment
        WHERE A1.inventory_id = '$inventory_id';";

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
    } else if ($action == '10'){
        $inventory_id = $_GET['inventory_id'];

        $query = "SELECT A1.inventory_id, A1.action, A2.employee_name, A1.action_dt
        FROM inventory_log A1
        LEFT JOIN employee A2 ON A1.action_by = A2.id
        WHERE A1.inventory_id = '$inventory_id';";

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
    } else if ($action == '11'){
        $request_id = $_GET['request_id'];

        $query = "SELECT A1.request_id, A1.action, A2.employee_name, A1.action_dt
        FROM inventory_request_log A1
        LEFT JOIN employee A2 ON A1.action_by = A2.id
        WHERE A1.request_id = '$request_id';";

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