<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $currentDate = date('Y-m-d');
    $currentMonth = date('n');
    $currentYear = date('Y');

    // Adjust year for January
    if ($currentMonth == 1) {
        $previousMonth = 12;
        $previousYear = $currentYear - 1;
    } else {
        $previousMonth = $currentMonth - 1;
        $previousYear = $currentYear;
    }

    $month = $previousMonth;
    $year = $previousYear;
    $employeeId = $_GET['employeeId'];

    //Get gaji tetap 
    $gajiTetapQuery = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-001'";
    $gajiTetapResult = $connect->query($gajiTetapQuery);

    while ($gajiTetapRow = $gajiTetapResult->fetch_assoc()){
        $gajiTetap = $gajiTetapRow['amount'];
    }

    //Get Jabatan
    $JabatanQuery = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-002'";
    $JabatanResult = $connect->query($JabatanQuery);

    while ($JabatanRow = $JabatanResult->fetch_assoc()){
        $Jabatan = $JabatanRow['amount'];
    }

    //Get BPJS Ketenag
    $BPJSKetenagQuery = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-003'";
    $BPJSKetenagResult = $connect->query($BPJSKetenagQuery);

    while ($BPJSKetenagRow = $BPJSKetenagResult->fetch_assoc()){
        $BPJSKetenag = $BPJSKetenagRow['amount'];
    }

    //Get BPJSKesehatan
    $BPJSKesehatanQuery = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-004'";
    $BPJSKesehatanResult = $connect->query($BPJSKesehatanQuery);

    while ($BPJSKesehatanRow = $BPJSKesehatanResult->fetch_assoc()){
        $BPJSKesehatan = $BPJSKesehatanRow['amount'];
    }

    //Get Lembur
    $LemburQuery = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-005'";
    $LemburResult = $connect->query($LemburQuery);

    while ($LemburRow = $LemburResult->fetch_assoc()){
        $Lembur = $LemburRow['amount'];
    }

    //Get Transport
    $TransportQuery = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-006'";
    $TransportResult = $connect->query($TransportQuery);

    while ($TransportRow = $TransportResult->fetch_assoc()){
        $Transport = $TransportRow['amount'];
    }

    //Get Lainnya
    $LainnyaQuery = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-007'";
    $LainnyaResult = $connect->query($LainnyaQuery);

    while ($LainnyaRow = $LainnyaResult->fetch_assoc()){
        $Lainnya = $LainnyaRow['amount'];
    }

    //Get Pinjaman
    $PinjamanQuery = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-008'";
    $PinjamanResult = $connect->query($PinjamanQuery);

    while ($PinjamanRow = $PinjamanResult->fetch_assoc()){
        $Pinjaman = $PinjamanRow['amount'];
    }

    //Get Pajak
    $PajakQuery = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-009'";
    $PajakResult = $connect->query($PajakQuery);

    while ($PajakRow = $PajakResult->fetch_assoc()){
        $Pajak = $PajakRow['amount'];
    }

    //Get PotBPJSKet1
    $PotBPJSKet1Query = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-010'";
    $PotBPJSKet1Result = $connect->query($PotBPJSKet1Query);

    while ($PotBPJSKet1Row = $PotBPJSKet1Result->fetch_assoc()){
        $PotBPJSKet1 = $PotBPJSKet1Row['amount'];
    }
    
    //Get PotBPJSKes1
    $PotBPJSKes1Query = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-011'";
    $PotBPJSKes1Result = $connect->query($PotBPJSKes1Query);

    while ($PotBPJSKes1Row = $PotBPJSKes1Result->fetch_assoc()){
        $PotBPJSKes1 = $PotBPJSKes1Row['amount'];
    }
    
    //Get PotBPJSKet2
    $PotBPJSKet2Query = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-012'";
    $PotBPJSKet2Result = $connect->query($PotBPJSKet2Query);

    while ($PotBPJSKet2Row = $PotBPJSKet2Result->fetch_assoc()){
        $PotBPJSKet2 = $PotBPJSKet2Row['amount'];
    }
    
    //Get PotBPJSKes2
    $PotBPJSKes2Query = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-013'";
    $PotBPJSKes2Result = $connect->query($PotBPJSKes2Query);

    while ($PotBPJSKes2Row = $PotBPJSKes2Result->fetch_assoc()){
        $PotBPJSKes2 = $PotBPJSKes2Row['amount'];
    }

    //Get PPHBonus
    $PPHBonusQuery = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-014'";
    $PPHBonusResult = $connect->query($PPHBonusQuery);

    while ($PPHBonusRow = $PPHBonusResult->fetch_assoc()){
        $PPHBonus = $PPHBonusRow['amount'];
    }
    
    //Get penguranganLainnya
    $penguranganLainnyaQuery = "SELECT amount FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND salary_category = 'SAL-015'";
    $penguranganLainnyaResult = $connect->query($penguranganLainnyaQuery);

    while ($penguranganLainnyaRow = $penguranganLainnyaResult->fetch_assoc()){
        $penguranganLainnya = $penguranganLainnyaRow['amount'];
    }
    
    //Get total 
    $totalQuery = "SELECT total_earnings, total_deductions, total_thp FROM salary_transaction WHERE month = '$month' AND year = '$year' AND employee_id = '$employeeId' AND total_earnings IS NOT NULL;";
    $totalResult = $connect->query($totalQuery);

    while ($totalRow = $totalResult->fetch_assoc()){
        $totalPenghasilan = $totalRow['total_earnings'];
        $totalPengurangan = $totalRow['total_deductions'];
        $totalTakeHomePay = $totalRow['total_thp'];
    }

    echo json_encode(
        array(
            'gajiTetap' => $gajiTetap,
            'Jabatan' => $Jabatan,
            'Transport' => $Transport,
            'BPJSKetenag' => $BPJSKetenag,
            'BPJSKesehatan' => $BPJSKesehatan,
            'Lembur' => $Lembur,
            'Lainnya' => $Lainnya,
            'Pinjaman' => $Pinjaman,
            'Pajak' => $Pajak,
            'PotBPJSKet1' => $PotBPJSKet1,
            'PotBPJSKes1' => $PotBPJSKes1,
            'PotBPJSKet2' => $PotBPJSKet2,
            'PotBPJSKes2' => $PotBPJSKes2,
            'PPHBonus' => $PPHBonus,
            'penguranganLainnya' => $penguranganLainnya,
            'totalPendapatan' => $totalPenghasilan,
            'totalPengurangan' => $totalPengurangan,
            'totalTakeHomePay' => $totalTakeHomePay
        )
    );

} else {
    // Handle other request methods or actions
}
?>

