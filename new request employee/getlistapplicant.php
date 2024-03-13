<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT SELECT A1.candidate_name, A2.position_name, A1.candidate_phone, A1.candidate_email, A1.candidate_surat_lamaran, A1.candidate_ijazah, A1.candidate_riwayat_hidup, A3.status_name, A1.job_ads
    FROM job_applicant A1
    LEFT JOIN job_ads A2 ON A1.job_ads = A2.id_job_ads
    LEFT JOIN new_request_employee_status_master A3 ON A1.status = A3.id_status;";
    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
        $employee = array();

        while ($row = $result->fetch_assoc()) {
            $employee[] = $row;
        }

        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status' => 'Success',
                'Data' => $employee
            )
        );
    } else {
        http_response_code(400);
        echo json_encode(
            array(
                'StatusCode' => 400,
                'Status' => 'Error Bad Request, Result not found !'
            )
        );
    }
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

?>