<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'];

    // For Dashboard
    if($action == '1'){
        $id = $_GET['id'];

        $myPermissionQuery = "SELECT A1.id_permission, A2.permission_type_name, A3.employee_name ,A1.permission_date, A4.permission_status_name, A1.start_date
        FROM permission_log A1
        JOIN permission_type_master A2 ON A1.permission_type = A2.id_permission_type
        JOIN employee A3 ON A1.employee_id = A3.id
        JOIN permission_status_master A4 ON A1.last_permission_status = A4.id_permission_status
        WHERE A1.employee_id = '$id' ORDER BY A1.created_dt DESC;";
        $myPermissionResult = mysqli_query($connect, $myPermissionQuery);

        if (!$myPermissionResult) {
            http_response_code(500);
            echo json_encode([
                "StatusCode" => 500,
                'Status' => 'Error',
                "message" => "Error in myPermissionQuery: " . mysqli_error($connect)
            ]);
            return;
        }

        $myPermission = array();
        while ($myPermissionRow = mysqli_fetch_assoc($myPermissionResult)) {
            $myPermission[] = $myPermissionRow;
        }

        $managerApprovalQuery = "SELECT A1.id_permission, A3.permission_type_name, A2.employee_name ,A1.permission_date, A4.permission_status_name, A1.start_date
        FROM permission_log A1
        JOIN employee A2 ON A1.employee_id = A2.id
        JOIN permission_type_master A3 ON A1.permission_type = A3.id_permission_type
        JOIN permission_status_master A4 ON A1.last_permission_status = A4.id_permission_status
        WHERE A2.employee_spv = '$id' ORDER BY A1.created_dt DESC;";
        $managerApprovalResult = mysqli_query($connect, $managerApprovalQuery);

        if (!$managerApprovalResult) {
            http_response_code(500);
            echo json_encode([
                "StatusCode" => 500,
                'Status' => 'Error',
                "message" => "Error in managerApprovalQuery: " . mysqli_error($connect)
            ]);
            return;
        }

        $managerApprovalPermission = array();
        while ($managerApprovalPermissionRow = mysqli_fetch_assoc($managerApprovalResult)) {
            $managerApprovalPermission[] = $managerApprovalPermissionRow;
        }

        $HRDApprovalQuery = "SELECT A1.id_permission, A3.permission_type_name, A2.employee_name ,A1.permission_date, A4.permission_status_name, A1.start_date
        FROM permission_log A1
        JOIN employee A2 ON A1.employee_id = A2.id
        JOIN permission_type_master A3 ON A1.permission_type = A3.id_permission_type
        JOIN permission_status_master A4 ON A1.last_permission_status = A4.id_permission_status
        ORDER BY A1.created_dt;";
        $HRDApprovalResult = mysqli_query($connect, $HRDApprovalQuery);

        if (!$HRDApprovalResult) {
            http_response_code(500);
            echo json_encode([
                "StatusCode" => 500,
                'Status' => 'Error',
                "message" => "Error in HRDApprovalQuery: " . mysqli_error($connect)
            ]);
            return;
        }

        $HRDApprovalPermission = array();
        while ($HRDApprovalRow = mysqli_fetch_assoc($HRDApprovalResult)) {
            $HRDApprovalPermission[] = $HRDApprovalRow;
        }

        http_response_code(200);
        echo json_encode([
            'StatusCode' => 200,
            'Status' => 'Success',
            'Data' => [
                'myPermission' => $myPermission,
                'managerApproval' => $managerApprovalPermission,
                'HRDApproval' => $HRDApprovalPermission
            ]
        ]);

    // Take permission type
    } else if ($action == '2') {
        $query = "SELECT * FROM permission_type_master;";

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
    //search by name, department id, and position id
    } else if ($action == '3') {
        $employee_name = $_GET['employee_name'];
        $department_id = $_GET['department_id'];
        $permission_id = $_GET['permission_id'];

        // Sanitize the input variables
        $employee_name = mysqli_real_escape_string($connect, $employee_name);
        $department_id = mysqli_real_escape_string($connect, $department_id);
        $permission_id = mysqli_real_escape_string($connect, $permission_id);

        $query = "SELECT A1.id_permission, A3.permission_type_name, A2.employee_name, A1.permission_date, A4.permission_status_name, A1.start_date
        FROM permission_log A1
        JOIN employee A2 ON A1.employee_id = A2.id
        JOIN permission_type_master A3 ON A1.permission_type = A3.id_permission_type
        JOIN permission_status_master A4 ON A1.last_permission_status = A4.id_permission_status
        WHERE A2.employee_name LIKE '%$employee_name%' OR A2.department_id = '$department_id' OR A3.id_permission_type = '$permission_id'
        ORDER BY A1.created_dt;";
        $result = mysqli_query($connect, $query);

        if (!$result) {
            http_response_code(500);
            echo json_encode([
                "StatusCode" => 500,
                'Status' => 'Error',
                "message" => "Error in query: " . mysqli_error($connect)
            ]);
            return;
        }

        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        http_response_code(200);
        echo json_encode([
            'StatusCode' => 200,
            'Status' => 'Success',
            'Data' => $data
        ]);

    }
    // Add more conditions for other actions if needed
} else {
    http_response_code(405);
    echo json_encode([
        "StatusCode" => 405,
        'Status' => 'Error',
        "message" => "Error: Invalid method. Only GET requests are allowed."
    ]);
}
?>
