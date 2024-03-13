<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeId = $_POST['employeeId'];
    $requestId = $_POST['requestId'];
    $requestPosisi = $_POST['requestPosisi'];
    $requestJumlah = $_POST['requestJumlah'];
    $requestAlasan = $_POST['requestAlasan'];
    $requestGender = $_POST['requestGender'];
    $requestHubunganKerja = $_POST['requestHubunganKerja'];
    $requestStatusKaryawan = $_POST['requestStatusKaryawan'];
    $requestMinUsia = $_POST['requestMinUsia'];
    $requestMaxUsia = $_POST['requestMaxUsia'];
    $requestTinggiBadan = $_POST['requestTinggiBadan'];
    $requestBeratBadan = $_POST['requestBeratBadan'];
    $requestFakultas = $_POST['requestFakultas'];
    $requestJurusan = $_POST['requestJurusan'];
    $requestIPK = $_POST['requestIPK'];
    $requestLamaPengalaman = $_POST['requestLamaPengalaman'];
    $requestPeran = $_POST['requestPeran'];
    $requestKeahlianLain = $_POST['requestKeahlianLain'];
    $requestKualifikasi = $_POST['requestKualifikasi'];
    $requestPIC = $_POST['requestPIC'];
    $requestRincianTugas = $_POST['requestRincianTugas'];
    $requestMulaiKerja = $_POST['requestMulaiKerja'];
    $requestCatatanlain = $_POST['requestCatatanlain'];
    $requestDateInsert = $_POST['requestDateInsert'];
    $lastStatus = 'NEW-STATUS-001';
    $action = 'Pengajuan karyawan baru telah berhasil diajukan';


    $query = "INSERT IGNORE INTO new_employee_request 
        (id_new_employee_request, requestor_employee_id, posisi_diajukan, jumlah_karyawan_diajukan, reason_new_request, gender, hubungan_kerja, status_karyawan, minimal_usia, maksimal_usia, tinggi_badan, berat_badan, fakultas, jurusan, ipk, lama_pengalaman, peran, keahlian_lain, 
        kualifikasi_serupa, pic_karyawan, rincian_tugas, mulai_kerja, catatan_lain, last_status, created_by, created_dt, updated_by, updated_dt) VALUES 
        ('$requestId', '$employeeId', '$requestPosisi', '$requestJumlah', '$requestAlasan', '$requestGender', '$requestHubunganKerja', '$requestStatusKaryawan', '$requestMinUsia', '$requestMaxUsia', '$requestTinggiBadan', '$requestBeratBadan', '$requestFakultas', '$requestJurusan', 
        '$requestIPK', '$requestLamaPengalaman', '$requestPeran', '$requestKeahlianLain', '$requestKualifikasi', '$requestPIC', '$requestRincianTugas', '$requestMulaiKerja', '$requestCatatanlain', 'NEW-STATUS-001', '$employeeId', '$requestDateInsert', NULL, NULL);;";
    
    if(mysqli_query($connect, $query)) {
        $last_permission_id_query = "SELECT id_new_employee_request FROM new_employee_request ORDER BY id_new_employee_request DESC LIMIT 1;";
        $result_last_permission_id = $connect->query($last_permission_id_query);

        $row = $result_last_permission_id->fetch_assoc();
        $last_permission_id = $row["id_new_employee_request"];

        $query_history = "INSERT IGNORE INTO permission_history 
        (id, new_request_id, action, action_by, action_dt) VALUES 
        (NULL, '$id_new_employee_request', '$action', '$employeeId', '$requestDateInsert');";

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