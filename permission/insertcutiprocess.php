<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    $queryGetSisaCuti = "SELECT leave_count FROM annual_leave WHERE employee_id = '$employeeId' AND expired_date > CURDATE();";
    $resultGetSisaCuti = mysqli_query($connect, $queryGetSisaCuti);

    if ($resultGetSisaCuti) {
        
        $rowGetSisaCuti = mysqli_fetch_assoc($resultGetSisaCuti);
        if ($rowGetSisaCuti) {
            $sisacuti = $rowGetSisaCuti['leave_count'];
        }

        if ($sisacuti >= $jumlahHariCuti) {
            $a = $sisacuti - $jumlahHariCuti;

            $queryUpdateEmployee = "UPDATE annual_leave SET leave_count = $a WHERE employee_id = '$employeeId';";
            $resultUpdateEmployee = mysqli_query($connect, $queryUpdateEmployee);

            // Generate UUID in PHP
            $permissionId = bin2hex(random_bytes(16));

            $queryInsertPermission = "INSERT INTO permission_log
            (`id_permission`, `permission_type`, `employee_id`, `permission_date`, `permission_reason`, `permission_time`, 
            `cuti_phone`, `start_date`, `end_date`, `pengganti_cuti`, `last_permission_status`, `reject_reason`, 
            `created_by`, `created_dt`, `update_by`, `update_dt`) 
            VALUES 
            ('$permissionId', '$permissionType', '$employeeId', NULL, '$permissionReason', NULL, '$cutiPhone', '$startCuti', '$endCuti', '$penggantiCuti', '$lastPermissionStatus', NULL, '$createdBy', '$createdDt', NULL, NULL)";

            if (mysqli_query($connect, $queryInsertPermission)) {
                $query_history = "INSERT INTO permission_history 
                (id, permission_id, action, action_by, action_dt) VALUES 
                (NULL, '$permissionId', '$action', '$employeeId', '$createdDt');";

                if (mysqli_query($connect, $query_history)) {
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
            } else {
                http_response_code(400);
                echo json_encode(
                    array(
                        "StatusCode" => 400,
                        'Status' => 'Error',
                        "message" => "Error: Unable to insert permission data - " . mysqli_error($connect)
                    )
                );
            }

        } else {
            http_response_code(206);
            echo json_encode(array("status" => "Error", "message" => "Jatah cuti anda tidak cukup $sisacuti"));
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
