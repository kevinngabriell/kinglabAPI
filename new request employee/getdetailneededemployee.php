<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $request_id = $_GET['request_id'];

    $query = "SELECT A1.position_name, A1.job_desc, A1.criteria, A1.location, A3.gender_name, A2.minimal_usia, A2.maksimal_usia, A2.tinggi_badan, A2.berat_badan, A2.fakultas, A2.jurusan, A2.ipk, A2.lama_pengalaman, A2.peran, A2.keahlian_lain, A4.employee_name as kualifikasi_serupa, A5.employee_name as PIC, A2.rincian_tugas, A2.catatan_lain
    FROM job_ads A1
    LEFT JOIN new_employee_request A2 ON A1.request_id = A2.id_new_employee_request
    LEFT JOIN gender_db A3 ON A2.gender = A3.gender_id
    LEFT JOIN employee A4 ON A2.kualifikasi_serupa = A4.id
    LEFT JOIN employee A5 ON A2.pic_karyawan = A5.id
    WHERE A1.id_job_ads = '$request_id';";
    
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