<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $query_one = "SELECT COUNT(*) as semua FROM job_applicant;";
    $result_one = $connect->query($query_one);
    $jumlahSemua = array();
    while($row_one = $result_one->fetch_assoc()){
        $jumlahSemua[] = $row_one;
    }

    $query_two = "SELECT COUNT(*) as proses
    FROM job_applicant
    WHERE status = 'NEW-STATUS-007' OR status = 'NEW-STATUS-008' OR status = 'NEW-STATUS-009' OR status = 'NEW-STATUS-013' OR status = 'NEW-STATUS-014';";
    $result_two = $connect->query($query_two);
    $jumlahProses = array();
    while($row_two = $result_two->fetch_assoc()){
        $jumlahProses[] = $row_two;
    }

    $query_three = "SELECT COUNT(*) as diterima
    FROM job_applicant
    WHERE status = 'NEW-STATUS-010';";
    $result_three = $connect->query($query_three);
    $jumlahDiterima = array();
    while($row_three = $result_three->fetch_assoc()){
        $jumlahDiterima[] = $row_three;
    }

    $query_four = "SELECT COUNT(*) as ditolak
    FROM job_applicant
    WHERE status = 'NEW-STATUS-011';";
    $result_four = $connect->query($query_four);
    $jumlahDitolak = array();
    while($row_four = $result_four->fetch_assoc()){
        $jumlahDitolak[] = $row_four;
    }

    echo json_encode(
        array(
            'StatusCode' => 200,
            'Status' => 'Success',
            'Data' => [
                'semuaPelamar' => $jumlahSemua[0]['semua'],
                'proses' => $jumlahProses[0]['proses'],
                'diterima' => $jumlahDiterima[0]['diterima'],
                'ditolak' => $jumlahDitolak[0]['ditolak'],
            ]
        )
    );

} else {
    http_response_code(405);
    echo json_encode(
        array(
            'StatusCode' => 405,
            'Status' => 'Error',
            'Message' => 'Please check your method request'
        )
    );
}