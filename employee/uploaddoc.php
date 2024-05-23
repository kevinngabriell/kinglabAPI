<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = $_POST['employee_id'];
    $action = $_POST['action_id'];
    $doc = $_POST['doc'];

    if($action == '1'){
        $query = "UPDATE employee_docs_agreement SET file_ktp = ? WHERE id = ?";
        $stmt = mysqli_prepare($connect, $query);
    
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "si", $doc, $employee_id);
            $result = mysqli_stmt_execute($stmt);
    
            if ($result) {
                http_response_code(200);
                echo json_encode(array(
                    "StatusCode" => 200,
                    'Status' => 'Success',
                    "message" => "Success: Data updated successfully"
                ));
            } else {
                http_response_code(400);
                echo json_encode(array(
                    "StatusCode" => 400,
                    'Status' => 'Error',
                    "message" => "Error: Unable to update data - " . mysqli_error($connect)
                ));
            }
        } else {
            http_response_code(500);
            echo json_encode(array(
                "StatusCode" => 500,
                'Status' => 'Error',
                "message" => "Error: Database error - " . mysqli_error($connect)
            ));
        }
        
    } else if ($action == '2'){
        $query = "UPDATE employee_docs_agreement SET file_sim_a = ? WHERE id = ?";
        $stmt = mysqli_prepare($connect, $query);
    
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "si", $doc, $employee_id);
            $result = mysqli_stmt_execute($stmt);
    
            if ($result) {
                http_response_code(200);
                echo json_encode(array(
                    "StatusCode" => 200,
                    'Status' => 'Success',
                    "message" => "Success: Data updated successfully"
                ));
            } else {
                http_response_code(400);
                echo json_encode(array(
                    "StatusCode" => 400,
                    'Status' => 'Error',
                    "message" => "Error: Unable to update data - " . mysqli_error($connect)
                ));
            }
        } else {
            http_response_code(500);
            echo json_encode(array(
                "StatusCode" => 500,
                'Status' => 'Error',
                "message" => "Error: Database error - " . mysqli_error($connect)
            ));
        }
    } else if ($action == '3'){
        $query = "UPDATE employee_docs_agreement SET file_sim_c = ? WHERE id = ?";
        $stmt = mysqli_prepare($connect, $query);
    
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "si", $doc, $employee_id);
            $result = mysqli_stmt_execute($stmt);
    
            if ($result) {
                http_response_code(200);
                echo json_encode(array(
                    "StatusCode" => 200,
                    'Status' => 'Success',
                    "message" => "Success: Data updated successfully"
                ));
            } else {
                http_response_code(400);
                echo json_encode(array(
                    "StatusCode" => 400,
                    'Status' => 'Error',
                    "message" => "Error: Unable to update data - " . mysqli_error($connect)
                ));
            }
        } else {
            http_response_code(500);
            echo json_encode(array(
                "StatusCode" => 500,
                'Status' => 'Error',
                "message" => "Error: Database error - " . mysqli_error($connect)
            ));
        }
    } else if ($action == '4'){
        $query = "UPDATE employee_docs_agreement SET file_npwp = '$doc' WHERE id = '$employee_id'";

        if(mysqli_query($connect, $query)){
            http_response_code(200);
            echo json_encode(array(
                "StatusCode" => 200,
                'Status' => 'Success',
                "message" => "Success: Data inserted successfully"
            ));
        } else {
            http_response_code(400);
            echo json_encode(array(
                "StatusCode" => 400,
                'Status' => 'Error',
                "message" => "Error: Unable to insert data - " . mysqli_error($connect)
            ));
        }
    } else if ($action == '5'){
        $query = "UPDATE employee_docs_agreement SET file_bpjs = '$doc' WHERE id = '$employee_id'";

        if(mysqli_query($connect, $query)){
            http_response_code(200);
            echo json_encode(array(
                "StatusCode" => 200,
                'Status' => 'Success',
                "message" => "Success: Data inserted successfully"
            ));
        } else {
            http_response_code(400);
            echo json_encode(array(
                "StatusCode" => 400,
                'Status' => 'Error',
                "message" => "Error: Unable to insert data - " . mysqli_error($connect)
            ));
        }
    }

} else {
    http_response_code(404);
    echo json_encode(array(
        "StatusCode" => 404,
        'Status' => 'Error',
        "message" => "Error: Invalid method. Only POST requests are allowed."
    ));
}