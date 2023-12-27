<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $permissionType = 'PER-TYPE-003';
    $employeeId = $_POST['employee_id'];
    $cutiPhone = $_POST['cuti_phone'];
    $startCuti = $_POST['start_cuti'];
    $endCuti = $_POST['end_cuti'];
    $penggantiCuti = $_POST['pengganti_cuti'];
    $permissionReason = $_POST['permission_reason'];
    $lastPermissionStatus = 'PER-STATUS-001';
    $createdBy = $_POST['created_by'];
    $createdDt = $_POST['created_dt'];
    $action = 'Input cuti tahunan telah berhasil dilakukan';
    $datetime1 = new DateTime($startCuti);
    $datetime2 = new DateTime($endCuti);
    $interval = $datetime1->diff($datetime2);
    $jumlahHariCuti = $interval->days;

    $queryGetSisaCuti = "SELECT employee_cuti FROM employee WHERE id = ?";
    $stmtGetSisaCuti = mysqli_prepare($connect, $queryGetSisaCuti);
    mysqli_stmt_bind_param($stmtGetSisaCuti, 's', $employeeId);
    mysqli_stmt_execute($stmtGetSisaCuti);
    $resultGetSisaCuti = mysqli_stmt_get_result($stmtGetSisaCuti);

    if ($resultGetSisaCuti) {
        $rowGetSisaCuti = mysqli_fetch_assoc($resultGetSisaCuti);
        $sisacuti = $rowGetSisaCuti['employee_cuti'];

        if ($sisacuti >= $jumlahHariCuti) {
            $a = $sisacuti - $jumlahHariCuti;

            $queryUpdateEmployee = "UPDATE employee SET employee_cuti = ? WHERE id = ?";
            $stmtUpdateEmployee = mysqli_prepare($connect, $queryUpdateEmployee);
            mysqli_stmt_bind_param($stmtUpdateEmployee, 'ss', $a, $employeeId);
            mysqli_stmt_execute($stmtUpdateEmployee);

            $queryInsertPermission = "INSERT IGNORE INTO permission_log
            (`id_permission`, `permission_type`, `employee_id`, `permission_date`, `permission_reason`, `permission_time`, 
            `cuti_phone`, `start_cuti`, `end_cuti`, `pengganti_cuti`, `last_permission_status`, `reject_reason`, 
            `created_by`, `created_dt`, `update_by`, `update_dt`) 
            VALUES 
            (NULL, '$permissionType', '$employeeId', NULL, '$permissionReason', NULL, '$cutiPhone', '$startCuti', '$endCuti', '$penggantiCuti', '$lastPermissionStatus', NULL, '$createdBy', '$createdDt', NULL, NULL)";
            
            if(mysqli_query($connect, $queryInsertPermission)) {
                $last_permission_id_query = "SELECT id_permission FROM permission_log ORDER BY id_permission DESC LIMIT 1;";
                $result_last_permission_id = $connect->query($last_permission_id_query);
        
                $row = $result_last_permission_id->fetch_assoc();
                $last_permission_id = $row["id_permission"];
        
                $query_history = "INSERT IGNORE INTO permission_history 
                (id, permission_id, action, action_by, action_dt) VALUES 
                (NULL, '$last_permission_id', '$action', '$employeeId', '$createdDt');";
        
                if(mysqli_query($connect, $query_history)) {
                    http_response_code(200);
                    echo json_encode(
                        array(
                            "StatusCode" => 200,
                            'Status' => 'Success',
                            "message" => "Success: Data inserted successfully"
                        )
                    );
                } else {
                    http_response_code(404);
                echo json_encode(
                    array(
                        "StatusCode" => 400,
                        'Status' => 'Error',
                        "message" => "Error: Unable to insert data - " . mysqli_error($connect)
                    )
                );
                }
            }

        } else {
            http_response_code(206);
            echo json_encode(array("status" => "Error", "message" => "Jatah cuti anda tidak cukup $jumlahHariCuti $sisacuti"));
        }

    } else {
        http_response_code(500);
        echo json_encode(array("status" => "Error", "message" => "Error: Unable to fetch remaining leave days - " . mysqli_error($connect)));
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

?>