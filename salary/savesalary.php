<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Display error message
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeId = $_POST['employeeId'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $gajiTetap = $_POST['gajiTetap'];
    $Jabatan = $_POST['Jabatan'];
    $BPJSKetenag = $_POST['BPJSKetenag'];
    $BPJSKesehatan = $_POST['BPJSKesehatan'];
    $Lembur = $_POST['Lembur'];
    $Transport = $_POST['Transport'];
    $Lainnya = $_POST['Lainnya'];
    $Pinjaman = $_POST['Pinjaman'];
    $Pajak = $_POST['Pajak'];
    $PotBPJSKet1 = $_POST['PotBPJSKet1'];
    $PotBPJSKes1 = $_POST['PotBPJSKes1'];
    $PotBPJSKet2 = $_POST['PotBPJSKet2'];
    $PotBPJSKes2 = $_POST['PotBPJSKes2'];
    $PPHBonus = $_POST['PPHBonus'];
    $PotLainnya = $_POST['PotLainnya'];
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
        $gajiTetapQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-001', '$gajiTetap', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);"; 
        
        $result = mysqli_query($connect, $gajiTetapQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $gajiTetapQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-001', '0', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);"; 
        
        $result = mysqli_query($connect, $gajiTetapQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }   

    //Case 2 check apakah Jabatan 0 atau tidak
    if($Jabatan != null || $Jabatan != ''){
        $JabatanQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-002', '$Jabatan', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $JabatanQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $JabatanQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-002', '0', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $JabatanQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }

    //Case 3 check apakah BPJSKetenag 0 atau tidak
    if($BPJSKetenag != null || $BPJSKetenag != ''){
        $BPJSKetenagQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-003', '$BPJSKetenag', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";
        
        $result = mysqli_query($connect, $BPJSKetenagQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $BPJSKetenagQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-003', '0', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";
        
        $result = mysqli_query($connect, $BPJSKetenagQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }

    //Case 4 check apakah BPJSKesehatan 0 atau tidak
    if($BPJSKesehatan != null || $BPJSKesehatan != ''){
        $BPJSKesehatanQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-004', '$BPJSKesehatan', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $BPJSKesehatanQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $BPJSKesehatanQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-004', '0', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $BPJSKesehatanQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }

    //Case 5 check apakah lembur 0 atau tidak
    if($Lembur != null || $Lembur != ''){
        $lemburQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-005', '$Lembur', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $lemburQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $lemburQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-005', '0', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $lemburQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }

    //Case 6 check apakah Transport 0 atau tidak
    if($Transport != null || $Transport != ''){
        $TransportQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-006', '$Transport', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";
        
        $result = mysqli_query($connect, $TransportQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $TransportQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-006', '0', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";
        
        $result = mysqli_query($connect, $TransportQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }

    //Case 7 check apakah pendapatan lainnya 0 atau tidak
    if($Lainnya != null || $Lainnya != ''){
        $LainnyaQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-007', '$Lainnya', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $LainnyaQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $LainnyaQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-007', '0', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $LainnyaQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }

    //Case 8 check apakah Pinjaman 0 atau tidak
    if($Pinjaman != null || $Pinjaman != ''){
        $PinjamanQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-002', 'SAL-008', '$Pinjaman', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $PinjamanQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $PinjamanQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-002', 'SAL-008', '0', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $PinjamanQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }

    //Case 9 check apakah Pajak 0 atau tidak
    if($Pajak != null || $Pajak != ''){
        $PajakQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-002', 'SAL-009', '$Pajak', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $PajakQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $PajakQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-002', 'SAL-009', '0', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $PajakQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }

    //Case 10 check apakah PotBPJSKet1 0 atau tidak
    if($PotBPJSKet1 != null || $PotBPJSKet1 != ''){
        $PotBPJSKet1Query = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-002', 'SAL-010', '$PotBPJSKet1', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $PotBPJSKet1Query);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $PotBPJSKet1Query = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-002', 'SAL-010', '0', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $PotBPJSKet1Query);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }

    //Case 11 check apakah PotBPJSKes1 0 atau tidak
    if($PotBPJSKes1 != null || $PotBPJSKes1 != ''){
        $PotBPJSKes1Query = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-002', 'SAL-011', '$PotBPJSKes1', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $PotBPJSKes1Query);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $PotBPJSKes1Query = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-002', 'SAL-011', '0', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $PotBPJSKes1Query);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }
    
    //Case 12 check apakah PotBPJSKet2 0 atau tidak
    if($PotBPJSKet2 != null || $PotBPJSKet2 != ''){
        $PotBPJSKet2Query = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-002', 'SAL-012', '$PotBPJSKet2', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $PotBPJSKet2Query);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $PotBPJSKet2Query = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-002', 'SAL-012', '0', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $PotBPJSKet2Query);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }
    
    //Case 13 check apakah PotBPJSKes2 0 atau tidak
    if($PotBPJSKes2 != null || $PotBPJSKes2 != ''){
        $PotBPJSKes2Query = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-002', 'SAL-013', '$PotBPJSKes2', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $PotBPJSKes2Query);
        
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $PotBPJSKes2Query = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-002', 'SAL-013', '0', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $PotBPJSKes2Query);
        
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }

    //Case 14 check apakah PPHBonus 0 atau tidak
    if($PPHBonus != null || $PPHBonus != ''){
        $PPHBonusQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-002', 'SAL-014', '$PPHBonus', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $PPHBonusQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $PPHBonusQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-002', 'SAL-014', '0', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $PPHBonusQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }
    
    //Case 15 check apakah PotLainnya 0 atau tidak
    if($PotLainnya != null || $PotLainnya != ''){
        $PotLainnyaQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-002', 'SAL-015', '$PotLainnya', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $PotLainnyaQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        $PotLainnyaQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-002', 'SAL-015', '0', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $PotLainnyaQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    }
    
    //Case 16 cek apakah sudah ada kalkulasi perhitungan total pendapatan, pengurangan, dan take home pay
    if(($totalEarnings != null || $totalEarnings != '') && ($totalDeducations != null || $totalDeducations != '') && ($totalTakeHomePay != null || $totalTakeHomePay != '') ){
        $totalEarningsQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', NULL, NULL, NULL, '$totalEarnings', '$totalDeducations', '$totalTakeHomePay', '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

        $result = mysqli_query($connect, $totalEarningsQuery);
        if (!$result) {
            echo json_encode(array("error" => mysqli_error($connect)));
        }
    } else {
        // print("Tidak ada perhitungan pendapatan !!");
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