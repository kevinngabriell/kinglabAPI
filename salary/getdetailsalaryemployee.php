<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

//Display error message
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $month = $_GET['month'];
    $year = $_GET['year'];
    $employeeId = $_GET['employeeId'];

    //Get gaji tetap 
    $gajiTetapQuery = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-001'";
    $gajiTetapResult = $connect->query($gajiTetapQuery);

    while ($gajiTetapRow = $gajiTetapResult->fetch_assoc()){
        $gajiTetap = $gajiTetapRow['amount'];
    }

    //Get THR
    $THRQuery = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-002'";
    $THRResult = $connect->query($THRQuery);

    while ($THRRow = $THRResult->fetch_assoc()){
        $THR = $THRRow['amount'];
    }

    //Get Transport
    $TransportQuery = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-003'";
    $TransportResult = $connect->query($TransportQuery);

    while ($TransportRow = $TransportResult->fetch_assoc()){
        $Transport = $TransportRow['amount'];
    }

    //Get BPJS
    $BPJSQuery = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-004'";
    $BPJSResult = $connect->query($BPJSQuery);

    while ($BPJSRow = $BPJSResult->fetch_assoc()){
        $BPJS = $BPJSRow['amount'];
    }

    //Get Lembur
    $LemburQuery = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-005'";
    $LemburResult = $connect->query($LemburQuery);

    while ($LemburRow = $LemburResult->fetch_assoc()){
        $Lembur = $LemburRow['amount'];
    }

    //Get Bonus
    $BonusQuery = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-006'";
    $BonusResult = $connect->query($BonusQuery);

    while ($BonusRow = $BonusResult->fetch_assoc()){
        $Bonus = $BonusRow['amount'];
    }

    //Get Lainnya
    $LainnyaQuery = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-007'";
    $LainnyaResult = $connect->query($LainnyaQuery);

    while ($LainnyaRow = $LainnyaResult->fetch_assoc()){
        $Lainnya = $LainnyaRow['amount'];
    }

    //Get JHT
    $JHTQuery = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-008'";
    $JHTResult = $connect->query($JHTQuery);

    while ($JHTRow = $JHTResult->fetch_assoc()){
        $JHT = $JHTRow['amount'];
    }

    //Get JP
    $JPQuery = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-009'";
    $JPResult = $connect->query($JPQuery);

    while ($JPRow = $JPResult->fetch_assoc()){
        $JP = $JPRow['amount'];
    }

    //Get PPH
    $PPHQuery = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-010'";
    $PPHResult = $connect->query($PPHQuery);

    while ($PPHRow = $PPHResult->fetch_assoc()){
        $PPH = $PPHRow['amount'];
    }

    //Get penguranganLainnya
    $penguranganLainnyaQuery = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-011'";
    $penguranganLainnyaResult = $connect->query($penguranganLainnyaQuery);

    while ($penguranganLainnyaRow = $penguranganLainnyaResult->fetch_assoc()){
        $penguranganLainnya = $penguranganLainnyaRow['amount'];
    }

    echo json_encode(
        array(
            'StatusCode' => 200,
            'Status' => 'Success',
            'Data' => [
                'gajiTetap' => $gajiTetap,
                'THR' => $THR,
                'Transport' => $Transport,
                'BPJS' => $BPJS,
                'Lembur' => $Lembur,
                'Bonus' => $Bonus,
                'Lainnya' => $Lainnya,
                'JHT' => $JHT,
                'JP' => $JP,
                'PPH' => $PPH,
                'penguranganLainnya' => $penguranganLainnya
            ]
        )
    );

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