<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeId = $_POST['employeeId'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $gajiTetap = $_POST['gajiTetap'];
    $THR = $_POST['THR'];
    $Transport = $_POST['Transport'];
    $BPJS = $_POST['BPJS'];
    $Lembur = $_POST['Lembur'];
    $bonusTahunan = $_POST['bonusTahunan'];
    $pendapatanLainnya = $_POST['pendapatanLainnya'];
    $JHT = $_POST['JHT'];
    $JP = $_POST['JP'];
    $PPH = $_POST['PPH'];
    $pengguranganLainnya = $_POST['pengguranganLainnya'];
    $totalEarnings = $_POST['totalEarnings'];
    $totalDeducations = $_POST['totalDeducations'];
    $totalTakeHomePay = $_POST['totalTakeHomePay'];
    $requestorEmployeeId = $_POST['requestorEmployeeId'];

    $currentDateTime = new DateTime();
    
    $indonesiaTimeZone = new DateTimeZone('Asia/Jakarta');
    $currentDateTime->setTimezone($indonesiaTimeZone);

    $currentDateTimeString = $currentDateTime->format("Y-m-d H:i:s");

    //Case 1 check apakah gaji tetap 0 atau tidak
    if($gajiTetap != null || $gajiTetap != ''){
        $gajiTetapQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-001', '$gajiTetap', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);"; 
        
        $result = mysqli_query($connect, $gajiTetapQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $gajiTetapQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-001', '0', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);"; 
        
        $result = mysqli_query($connect, $gajiTetapQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }   

    //Case 2 check apakah THR 0 atau tidak
    if($THR != null || $THR != ''){
        $THRQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-002', '$THR', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $THRQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $THRQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-002', '0', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $THRQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }

    //Case 3 check apakah transport 0 atau tidak
    if($Transport != null || $Transport != ''){
        $transportQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-003', '$Transport', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";
        
        $result = mysqli_query($connect, $transportQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $transportQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-003', '0', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";
        
        $result = mysqli_query($connect, $transportQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }

    //Case 4 check apakah bpjs 0 atau tidak
    if($BPJS != null || $BPJS != ''){
        $bpjsQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-004', '$BPJS', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $bpjsQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $bpjsQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-004', '0', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $bpjsQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }

    //Case 5 check apakah lembur 0 atau tidak
    if($Lembur != null || $Lembur != ''){
        $lemburQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-005', '$Lembur', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $lemburQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $lemburQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-005', '0', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $lemburQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }

    //Case 6 check apakah bonus 0 atau tidak
    if($bonusTahunan != null || $bonusTahunan != ''){
        $bonusTahunanQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-006', '$bonusTahunan', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";
        
        $result = mysqli_query($connect, $bonusTahunanQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $bonusTahunanQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-006', '0', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";
        
        $result = mysqli_query($connect, $bonusTahunanQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }

    //Case 7 check apakah pendapatan lainnya 0 atau tidak
    if($pendapatanLainnya != null || $pendapatanLainnya != ''){
        $pendapatanLainnyaQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-007', '$pendapatanLainnya', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $pendapatanLainnyaQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $pendapatanLainnyaQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-007', '0', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $pendapatanLainnyaQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }

    //Case 8 check apakah JHT 0 atau tidak
    if($JHT != null || $JHT != ''){
        $JHTQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-002', 'SAL-008', '$JHT', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $JHTQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $JHTQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-002', 'SAL-008', '0', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $JHTQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }

    //Case 9 check apakah JP 0 atau tidak
    if($JP != null || $JP != ''){
        $JPQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-002', 'SAL-009', '$JP', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $JPQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $JPQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-002', 'SAL-009', '0', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $JPQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }

    //Case 10 check apakah PPH 0 atau tidak
    if($PPH != null || $PPH != ''){
        $PPHQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-002', 'SAL-010', '$PPH', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $PPHQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $PPHQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-002', 'SAL-010', '0', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $PPHQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }

    //Case 11 check apakah pengurangan lainnya 0 atau tidak
    if($pengguranganLainnya != null || $pengguranganLainnya != ''){
        $pengguranganLainnyaQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-002', 'SAL-011', '$pengguranganLainnya', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $pengguranganLainnyaQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $pengguranganLainnyaQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-002', 'SAL-011', '0', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $pengguranganLainnyaQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }

    //Case 12 cek apakah sudah ada kalkulasi perhitungan total pendapatan, pengurangan, dan take home pay
    if(($totalEarnings != null || $totalEarnings != '') && ($totalDeducations != null || $totalDeducations != '') && ($totalTakeHomePay != null || $totalTakeHomePay != '') ){
        $totalEarningsQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', NULL, NULL, NULL, '$totalEarnings', '$totalDeducations', '$totalTakeHomePay', '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $totalEarningsQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        print("Tidak ada perhitungan pendapatan !!");
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