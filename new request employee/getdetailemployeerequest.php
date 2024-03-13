<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $request_id = $_GET['request_id'];

    $query = "SELECT A1.id_new_employee_request, A2.employee_name, A3.position_name, A4.department_name, A1.posisi_diajukan, A1.jumlah_karyawan_diajukan, A5.request_reason, A6.gender_name, A7.hubungan_kerja_name, A8.status_name, A1.minimal_usia, A1.maksimal_usia, A1.tinggi_badan, A1.berat_badan, A1.fakultas, A1.jurusan, A1.ipk, A1.lama_pengalaman, A1.peran, A1.keahlian_lain, A1.rincian_tugas, A1.mulai_kerja, A1.catatan_lain, A9.status_name
    FROM new_employee_request A1
    JOIN employee A2 ON A2.id = A1.requestor_employee_id
    JOIN position_db A3 ON A3.position_id = A2.position_id
    JOIN department A4 ON A4.department_id = A2.department_id
    JOIN new_employee_reason A5 ON A5.reason_request_id = A1.reason_new_request
    JOIN gender_db A6 ON A6.gender_id = A1.gender
    JOIN hubungan_kerja_db A7 ON A7.hubungan_kerja_id = A1.hubungan_kerja
    JOIN status_db A8 ON A8.status_id = A1.status_karyawan
    JOIN new_request_employee_status_master A9 ON A9.id_status = A1.last_status
    WHERE A1.id_new_employee_request = '$request_id';";
    $result = $connect->query($query);

    if($result->num_rows > 0){
        $jatahCuti = array();

        while($row = $result->fetch_assoc()){
            $jatahCuti[] = $row;
        }

        http_response_code(200);
        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status' => 'Success',
                'Data' => $jatahCuti
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