<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $reportType = $_GET['reportType'];
    $departmentId = $_GET['departmentId'];
    $year = $_GET['year'];
    $month = $_GET['month'];

    //Jika laporan absen
    if($reportType == '1'){
        //Cek department yang dipilih jika 0 maka semua departemen
        if($departmentId == 'DEPT-HR-000'){
            $query = "SELECT A2.employee_name, A3.department_name, A4.position_name, A1.date, A1.time, A1.location, A5.absence_type_name, A6.presence_type_name, A1.is_valid
            FROM absence_log A1
            JOIN employee A2 ON A1.employee_id = A2.id
            JOIN department A3 ON A2.department_id = A3.department_id
            JOIN position_db A4 ON A2.position_id = A4.position_id
            JOIN absence_type A5 ON A1.absence_type = A5.id_absence_type
            JOIN presence_type A6 ON A1.presence_type = A6.id_presence_type
            WHERE MONTH(A1.date) = $month AND YEAR(A1.date) = $year;";
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
        } else {
            $query = "SELECT A2.employee_name, A3.department_name, A4.position_name, A1.date, A1.time, A1.location, A5.absence_type_name, A6.presence_type_name, A1.is_valid
            FROM absence_log A1
            JOIN employee A2 ON A1.employee_id = A2.id
            JOIN department A3 ON A2.department_id = A3.department_id
            JOIN position_db A4 ON A2.position_id = A4.position_id
            JOIN absence_type A5 ON A1.absence_type = A5.id_absence_type
            JOIN presence_type A6 ON A1.presence_type = A6.id_presence_type
            WHERE MONTH(A1.date) = $month AND YEAR(A1.date) = $year AND A3.department_id = $departmentId;";
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
    
    //Jika laporan sisa cuti
    } else if ($reportType == '2'){
        //Cek departement yang dipilih jika 0 maka semua departemen
        if($departmentId == 'DEPT-HR-000'){

            $query = "SELECT A2.employee_name, A3.department_name, A4.position_name, A1.leave_count, A1.expired_date
            FROM annual_leave A1
            LEFT JOIN employee A2 ON A1.employee_id = A2.id
            LEFT JOIN department A3 ON A2.department_id = A3.department_id
            LEFT JOIN position_db A4 ON A2.position_id = A4.position_id;";
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
        } else {
            $query = "SELECT A2.employee_name, A3.department_name, A4.position_name, A1.leave_count, A1.expired_date
            FROM annual_leave A1
            LEFT JOIN employee A2 ON A1.employee_id = A2.id
            LEFT JOIN department A3 ON A2.department_id = A3.department_id
            LEFT JOIN position_db A4 ON A2.position_id = A4.position_id
            WHERE a2.department_id = '$departmentId';";
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
    } else if ($reportType == '3'){

    } else if ($reportType == '4'){
        //Cek departement yang dipilih jika 0 maka semua departemen
        if($departmentId == 'DEPT-HR-000'){

            $query = "SELECT A1.employee_id, A1.employee_name, A2.department_name, A3.position_name, A1.employee_pob, A1.employee_dob, A4.employee_phone_number, A1.employee_identity, A4.employee_address_ktp
            FROM employee A1
            LEFT JOIN department A2 ON A1.department_id = A2.department_id
            LEFT JOIN position_db A3 ON A1.position_id = A3.position_id
            LEFT JOIN employee_contact_details_db A4 ON A1.id = A4.id;";

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

        } else {

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