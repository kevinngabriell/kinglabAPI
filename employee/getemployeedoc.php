<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $action = $_GET['action'];
    $employeeId = $_GET['employee_id'];

    if($action == '1'){
        $query = "SELECT file_ktp FROM employee_docs_agreement WHERE id = ?";
        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, 's', $employeeId);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $ktp = $row['file_ktp'];
                echo json_encode(array('ktp' => $ktp));
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
            http_response_code(500);
            echo json_encode(
                array(
                    'StatusCode' => 500,
                    'Status' => 'Error',
                    'message' => 'Error: Unable to execute query - ' . mysqli_error($connect)
                )
            );
        }
    } else if ($action == '2'){
        $query = "SELECT file_sim_a FROM employee_docs_agreement WHERE id = ?";
        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, 's', $employeeId);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $simA = $row['file_sim_a'];
                echo json_encode(array('simA' => $simA));
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
            http_response_code(500);
            echo json_encode(
                array(
                    'StatusCode' => 500,
                    'Status' => 'Error',
                    'message' => 'Error: Unable to execute query - ' . mysqli_error($connect)
                )
            );
        }
    } else if ($action == '3'){
        $query = "SELECT file_sim_c FROM employee_docs_agreement WHERE id = ?";
        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, 's', $employeeId);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $simC = $row['file_sim_c'];
                echo json_encode(array('simC' => $simC));
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
            http_response_code(500);
            echo json_encode(
                array(
                    'StatusCode' => 500,
                    'Status' => 'Error',
                    'message' => 'Error: Unable to execute query - ' . mysqli_error($connect)
                )
            );
        }
    } else if ($action == '4'){
        $query = "SELECT file_npwp FROM employee_docs_agreement WHERE id = ?";
        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, 's', $employeeId);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $npwp = $row['file_npwp'];
                echo json_encode(array('npwp' => $npwp));
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
            http_response_code(500);
            echo json_encode(
                array(
                    'StatusCode' => 500,
                    'Status' => 'Error',
                    'message' => 'Error: Unable to execute query - ' . mysqli_error($connect)
                )
            );
        }
    } else if ($action == '5'){
        $query = "SELECT file_bpjs FROM employee_docs_agreement WHERE id = ?";
        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, 's', $employeeId);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $bpjs = $row['file_bpjs'];
                echo json_encode(array('bpjs' => $bpjs));
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
            http_response_code(500);
            echo json_encode(
                array(
                    'StatusCode' => 500,
                    'Status' => 'Error',
                    'message' => 'Error: Unable to execute query - ' . mysqli_error($connect)
                )
            );
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