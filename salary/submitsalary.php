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

        //check first is the amount is exist or not
        $checkGajiTetapQuery = "SELECT COUNT(*)
        FROM salary_transaction A1
        LEFT JOIN salary_category A2 ON A1.salary_category = A2.id_salary_category
        WHERE A1.month = $month AND A1.year = $year AND A1.employee_id = '$employeeId' AND A1.salary_category = 'SAL-001';";
        $searchResult = $connect->query($checkGajiTetapQuery);

        if($searchResult->num_rows > 0){
            $updateGajiTetap = "UPDATE salary_transaction SET amount = '$gajiTetap', is_complete = '1', update_by = '$requestorEmployeeId', update_dt = '$currentDateTimeString' WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-001';";
            
            $result = mysqli_query($connect, $updateGajiTetap);
            if (!$result) {
                echo json_encode(array("error" => mysqli_error($connect)));
            }
        } else {
            $gajiTetapQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-001', '$gajiTetap', NULL, NULL, NULL, '1', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);"; 
        
            $result = mysqli_query($connect, $gajiTetapQuery);
            if (!$result) {
                echo json_encode(array("error" => mysqli_error($connect)));
            }
        }

        
    } else {
        print("Gaji tetap kosong !!");
    }   

    //Case 2 check apakah THR 0 atau tidak
    if($THR != null || $THR != ''){

        //check first is the amount is exist or not
        $checkTHRQuery = "SELECT COUNT(*)
        FROM salary_transaction A1
        LEFT JOIN salary_category A2 ON A1.salary_category = A2.id_salary_category
        WHERE A1.month = $month AND A1.year = $year AND A1.employee_id = '$employeeId' AND A1.salary_category = 'SAL-002';";
        $searchResult = $connect->query($checkTHRQuery);

        if($searchResult->num_rows > 0){
            $updateTHR = "UPDATE salary_transaction SET amount = '$THR', is_complete = '1', update_by = '$requestorEmployeeId', update_dt = '$currentDateTimeString' WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-002';";
            
            $result = mysqli_query($connect, $updateTHR);
            if (!$result) {
                echo json_encode(array("error" => mysqli_error($connect)));
            }
        } else {
            $THRQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-002', '$THR', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

            $result = mysqli_query($connect, $THRQuery);
            if (!$result) {
                echo json_encode(array("error" => mysqli_error($connect)));
            }
        }

        
    } else {
        print("THR kosong !!");
    }

    //Case 3 check apakah transport 0 atau tidak
    if($Transport != null || $Transport != ''){

         //check first is the amount is exist or not
         $checkTransportQuery = "SELECT COUNT(*)
         FROM salary_transaction A1
         LEFT JOIN salary_category A2 ON A1.salary_category = A2.id_salary_category
         WHERE A1.month = $month AND A1.year = $year AND A1.employee_id = '$employeeId' AND A1.salary_category = 'SAL-003';";
         $searchResult = $connect->query($checkTransportQuery);
 
         if($searchResult->num_rows > 0){
             $updateTransport = "UPDATE salary_transaction SET amount = '$Transport', is_complete = '1', update_by = '$requestorEmployeeId', update_dt = '$currentDateTimeString' WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-003';";
             
             $result = mysqli_query($connect, $updateTransport);
             if (!$result) {
                 echo json_encode(array("error" => mysqli_error($connect)));
             }
         } else {
             $TransportQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-003', '$Transport', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";
 
             $result = mysqli_query($connect, $TransportQuery);
             if (!$result) {
                 echo json_encode(array("error" => mysqli_error($connect)));
             }
         }

    } else {
        print("Transport kosong !!");
    }

    //Case 4 check apakah bpjs 0 atau tidak
    if($BPJS != null || $BPJS != ''){

        //check first is the amount is exist or not
        $checkBPJSQuery = "SELECT COUNT(*)
        FROM salary_transaction A1
        LEFT JOIN salary_category A2 ON A1.salary_category = A2.id_salary_category
        WHERE A1.month = $month AND A1.year = $year AND A1.employee_id = '$employeeId' AND A1.salary_category = 'SAL-004';";
        $searchResult = $connect->query($checkBPJSQuery);

        if($searchResult->num_rows > 0){
            $updateBPJS = "UPDATE salary_transaction SET amount = '$BPJS', is_complete = '1', update_by = '$requestorEmployeeId', update_dt = '$currentDateTimeString' WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-004';";
            
            $result = mysqli_query($connect, $updateBPJS);
            if (!$result) {
                echo json_encode(array("error" => mysqli_error($connect)));
            }
        } else {
            $BPJSQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-004', '$BPJS', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

            $result = mysqli_query($connect, $BPJSQuery);
            if (!$result) {
                echo json_encode(array("error" => mysqli_error($connect)));
            }
        }

    } else {
        print("BPJS kosong !!");
    }

    //Case 5 check apakah lembur 0 atau tidak
    if($Lembur != null || $Lembur != ''){

        //check first is the amount is exist or not
        $checkLemburQuery = "SELECT COUNT(*)
        FROM salary_transaction A1
        LEFT JOIN salary_category A2 ON A1.salary_category = A2.id_salary_category
        WHERE A1.month = $month AND A1.year = $year AND A1.employee_id = '$employeeId' AND A1.salary_category = 'SAL-005';";
        $searchResult = $connect->query($checkLemburQuery);

        if($searchResult->num_rows > 0){
            $updateLembur = "UPDATE salary_transaction SET amount = '$Lembur', is_complete = '1', update_by = '$requestorEmployeeId', update_dt = '$currentDateTimeString' WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-005';";
            
            $result = mysqli_query($connect, $updateLembur);
            if (!$result) {
                echo json_encode(array("error" => mysqli_error($connect)));
            }
        } else {
            $LemburQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-005', '$Lembur', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

            $result = mysqli_query($connect, $LemburQuery);
            if (!$result) {
                echo json_encode(array("error" => mysqli_error($connect)));
            }
        }

    } else {
        print("Lembur kosong !!");
    }

    //Case 6 check apakah bonus 0 atau tidak
    if($bonusTahunan != null || $bonusTahunan != ''){

        //check first is the amount is exist or not
        $checkbonusTahunanQuery = "SELECT COUNT(*)
        FROM salary_transaction A1
        LEFT JOIN salary_category A2 ON A1.salary_category = A2.id_salary_category
        WHERE A1.month = $month AND A1.year = $year AND A1.employee_id = '$employeeId' AND A1.salary_category = 'SAL-006';";
        $searchResult = $connect->query($checkbonusTahunanQuery);

        if($searchResult->num_rows > 0){
            $updatebonusTahunan = "UPDATE salary_transaction SET amount = '$bonusTahunan', is_complete = '1', update_by = '$requestorEmployeeId', update_dt = '$currentDateTimeString' WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-006';";
            
            $result = mysqli_query($connect, $updatebonusTahunan);
            if (!$result) {
                echo json_encode(array("error" => mysqli_error($connect)));
            }
        } else {
            $bonusTahunanQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-006', '$bonusTahunan', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

            $result = mysqli_query($connect, $bonusTahunanQuery);
            if (!$result) {
                echo json_encode(array("error" => mysqli_error($connect)));
            }
        }

    } else {
        print("Bonus tahunan kosong !!");
    }

    //Case 7 check apakah pendapatan lainnya 0 atau tidak
    if($pendapatanLainnya != null || $pendapatanLainnya != ''){

        //check first is the amount is exist or not
        $checkpendapatanLainnyaQuery = "SELECT COUNT(*)
        FROM salary_transaction A1
        LEFT JOIN salary_category A2 ON A1.salary_category = A2.id_salary_category
        WHERE A1.month = $month AND A1.year = $year AND A1.employee_id = '$employeeId' AND A1.salary_category = 'SAL-007';";
        $searchResult = $connect->query($checkpendapatanLainnyaQuery);

        if($searchResult->num_rows > 0){
            $updatependapatanLainnya = "UPDATE salary_transaction SET amount = '$pendapatanLainnya', is_complete = '1', update_by = '$requestorEmployeeId', update_dt = '$currentDateTimeString' WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-007';";
            
            $result = mysqli_query($connect, $updatependapatanLainnya);
            if (!$result) {
                echo json_encode(array("error" => mysqli_error($connect)));
            }
        } else {
            $pendapatanLainnyaQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-007', '$pendapatanLainnya', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

            $result = mysqli_query($connect, $pendapatanLainnyaQuery);
            if (!$result) {
                echo json_encode(array("error" => mysqli_error($connect)));
            }
        }

    } else {
        print("Pendapatan lainnya kosong !!");
    }

    //Case 8 check apakah JHT 0 atau tidak
    if($JHT != null || $JHT != ''){
        
        //check first is the amount is exist or not
        $checkJHTQuery = "SELECT COUNT(*)
        FROM salary_transaction A1
        LEFT JOIN salary_category A2 ON A1.salary_category = A2.id_salary_category
        WHERE A1.month = $month AND A1.year = $year AND A1.employee_id = '$employeeId' AND A1.salary_category = 'SAL-008';";
        $searchResult = $connect->query($checkJHTQuery);

        if($searchResult->num_rows > 0){
            $updateJHT = "UPDATE salary_transaction SET amount = '$JHT', is_complete = '1', update_by = '$requestorEmployeeId', update_dt = '$currentDateTimeString' WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-008';";
            
            $result = mysqli_query($connect, $updateJHT);
            if (!$result) {
                echo json_encode(array("error" => mysqli_error($connect)));
            }
        } else {
            $JHTQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-008', '$JHT', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

            $result = mysqli_query($connect, $JHTQuery);
            if (!$result) {
                echo json_encode(array("error" => mysqli_error($connect)));
            }
        }

    } else {
        print("JHT kosong !!");
    }

    //Case 9 check apakah JP 0 atau tidak
    if($JP != null || $JP != ''){

        //check first is the amount is exist or not
        $checkJPQuery = "SELECT COUNT(*)
        FROM salary_transaction A1
        LEFT JOIN salary_category A2 ON A1.salary_category = A2.id_salary_category
        WHERE A1.month = $month AND A1.year = $year AND A1.employee_id = '$employeeId' AND A1.salary_category = 'SAL-009';";
        $searchResult = $connect->query($checkJPQuery);

        if($searchResult->num_rows > 0){
            $updateJP = "UPDATE salary_transaction SET amount = '$JP', is_complete = '1', update_by = '$requestorEmployeeId', update_dt = '$currentDateTimeString' WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-009';";
            
            $result = mysqli_query($connect, $updateJP);
            if (!$result) {
                echo json_encode(array("error" => mysqli_error($connect)));
            }
        } else {
            $JPQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-009', '$JP', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

            $result = mysqli_query($connect, $JPQuery);
            if (!$result) {
                echo json_encode(array("error" => mysqli_error($connect)));
            }
        }

        
    } else {
        print("JP kosong !!");
    }

    //Case 10 check apakah PPH 0 atau tidak
    if($PPH != null || $PPH != ''){

        //check first is the amount is exist or not
        $checkPPHQuery = "SELECT COUNT(*)
        FROM salary_transaction A1
        LEFT JOIN salary_category A2 ON A1.salary_category = A2.id_salary_category
        WHERE A1.month = $month AND A1.year = $year AND A1.employee_id = '$employeeId' AND A1.salary_category = 'SAL-010';";
        $searchResult = $connect->query($checkPPHQuery);

        if($searchResult->num_rows > 0){
            $updatePPH = "UPDATE salary_transaction SET amount = '$PPH', is_complete = '1', update_by = '$requestorEmployeeId', update_dt = '$currentDateTimeString' WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-010';";
            
            $result = mysqli_query($connect, $updatePPH);
            if (!$result) {
                echo json_encode(array("error" => mysqli_error($connect)));
            }
        } else {
            $PPHQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-010', '$PPH', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

            $result = mysqli_query($connect, $PPHQuery);
            if (!$result) {
                echo json_encode(array("error" => mysqli_error($connect)));
            }
        }

    } else {
        print("Pendapatan lainnya kosong !!");
    }

    //Case 11 check apakah pengurangan lainnya 0 atau tidak
    if($pengguranganLainnya != null || $pengguranganLainnya != ''){

        //check first is the amount is exist or not
        $checkpengguranganLainnyaQuery = "SELECT COUNT(*)
        FROM salary_transaction A1
        LEFT JOIN salary_category A2 ON A1.salary_category = A2.id_salary_category
        WHERE A1.month = $month AND A1.year = $year AND A1.employee_id = '$employeeId' AND A1.salary_category = 'SAL-011';";
        $searchResult = $connect->query($checkpengguranganLainnyaQuery);

        if($searchResult->num_rows > 0){
            $updatepengguranganLainnya = "UPDATE salary_transaction SET amount = '$pengguranganLainnya', is_complete = '1', update_by = '$requestorEmployeeId', update_dt = '$currentDateTimeString' WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-011';";
            
            $result = mysqli_query($connect, $updatepengguranganLainnya);
            if (!$result) {
                echo json_encode(array("error" => mysqli_error($connect)));
            }
        } else {
            $pengguranganLainnyaQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', 'SALARY-TYPE-001', 'SAL-011', '$pengguranganLainnya', NULL, NULL, NULL, '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

            $result = mysqli_query($connect, $pengguranganLainnyaQuery);
            if (!$result) {
                echo json_encode(array("error" => mysqli_error($connect)));
            }
        }
    } else {
        print("Pendapatan lainnya kosong !!");
    }

    //Case 12 cek apakah sudah ada kalkulasi perhitungan total pendapatan, pengurangan, dan take home pay
    if(($totalEarnings != null || $totalEarnings != '') && ($totalDeducations != null || $totalDeducations != '') && ($totalTakeHomePay != null || $totalTakeHomePay != '') ){
        
        //check first is the amount is exist or not
        $checkallQuery = "SELECT COUNT(*)
        FROM salary_transaction A1
        LEFT JOIN salary_category A2 ON A1.salary_category = A2.id_salary_category
        WHERE A1.month = $month AND A1.year = $year AND A1.employee_id = '$employeeId' AND A1.total_earnings IS NOT NULL AND A1.total_deductions IS NOT NULL AND A1.total_thp IS NOT NULL;";
        $searchResult = $connect->query($checkallQuery);

        if($searchResult->num_rows > 0){
            $updateTotalQuery = "UPDATE salary_transaction SET total_earnings = '$totalEarnings', total_deductions = '$totalDeducations', total_thp = '$totalTakeHomePay', is_complete = '1', update_by = '$requestorEmployeeId', update_dt = '$currentDateTimeString' WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_type IS NULL AND salary_category IS NULL AND amount IS NULL";

            $result = mysqli_query($connect, $updateTotalQuery);
            if (!$result) {
                echo json_encode(array("error" => mysqli_error($connect)));
            }

        } else {
            $totalEarningsQuery = "INSERT INTO salary_transaction (employee_id, month, year, salary_type, salary_category, amount, total_earnings, total_deductions, total_thp, is_complete, insert_by, insert_dt, update_by, update_dt) VALUES ('$employeeId', '$month', '$year', NULL, NULL, NULL, '$totalEarnings', '$totalDeducations', '$totalTakeHomePay', '0', '$requestorEmployeeId', '$currentDateTimeString', NULL, NULL);";

            $result = mysqli_query($connect, $totalEarningsQuery);
            if (!$result) {
                echo json_encode(array("error" => mysqli_error($connect)));
            }
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