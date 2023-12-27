<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];
    $job_source_answer = $_POST['job_source_answer'];
    $job_source_answer_exp = $_POST['job_source_answer_exp'];
    $contact_last_comp = $_POST['contact_last_comp'];
    $position_applied = $_POST['position_applied'];
    $position_alternate = $_POST['position_alternate'];
    $expected_salary = $_POST['expected_salary'];
    $hubungan_kerja_answer = $_POST['hubungan_kerja_answer'];
    $is_ever_award = $_POST['is_ever_award'];
    $is_ever_award_exp = $_POST['is_ever_award_exp'];
    $hobby_answer = $_POST['hobby_answer'];
    $is_ever_org = $_POST['is_ever_org'];
    $is_ever_org_exp = $_POST['is_ever_org'];
    $is_day_unv = $_POST['is_day_unv'];
    $is_day_unv_exp = $_POST['is_day_unv_exp'];
    $is_any_sim = $_POST['is_any_sim'];
    $sim_a_end = $_POST['sim_a_end'];
    $sim_c_end = $_POST['sim_c_end'];
    $is_fired = $_POST['is_fired'];
    $is_fired_exp = $_POST['is_fired_exp'];
    $is_jailed = $_POST['is_jailed'];
    $is_jailed_exp = $_POST['is_jailed_exp'];
    $is_sick = $_POST['is_sick'];
    $is_sick_exp = $_POST['is_sick_exp'];
    $is_smoke = $_POST['is_smoke'];
    $emergency_name = $_POST['emergency_name'];
    $emergency_hubungan = $_POST['emergency_hubungan'];
    $emergency_phone = $_POST['emergency_phone'];
    $emergency_address = $_POST['emergency_address'];
    $emergency_name_2 = $_POST['emergency_name_2'];
    $emergency_hubungan_2 = $_POST['emergency_hubungan_2'];
    $emergency_phone_2 = $_POST['emergency_phone_2'];
    $emergency_address_2 = $_POST['emergency_address_2'];

    $query = "INSERT IGNORE INTO employee_question (id, job_source_answer, job_source_answer_exp, contact_last_comp, position_applied, position_alternate, expected_salary, hubungan_kerja_answer, is_ever_award, is_ever_award_exp, hobby_answer, is_ever_org, is_ever_org_exp, is_day_unv, is_day_unv_exp, is_any_sim, sim_a_end, sim_c_end, is_fired, is_fired_exp, is_jailed, is_jailed_exp, is_sick, is_sick_exp, is_smoke) VALUES 
    ('$id', '$job_source_answer', '$job_source_answer_exp', '$contact_last_comp', '$position_applied', '$position_alternate', '$expected_salary', '$hubungan_kerja_answer', '$is_ever_award', '$is_ever_award_exp', '$hobby_answer', '$is_ever_org', '$is_ever_org_exp', '$is_day_unv', '$is_day_unv_exp', '$is_any_sim', '$sim_a_end', '$sim_c_end', '$is_fired', '$is_fired_exp', '$is_jailed', '$is_jailed_exp', '$is_sick', '$is_sick_exp', '$is_smoke');";

    $query_2 = "INSERT IGNORE INTO employee_emergency_contact (id, emergency_name, emergency_hubungan, emergency_phone, emergency_address, emergency_name_2, emergency_hubungan_2, emergency_phone_2, emergency_address_2) VALUES ('$id', '$emergency_name', '$emergency_hubungan', '$emergency_phone', '$emergency_address', '$emergency_name_2', '$emergency_hubungan_2', '$emergency_phone_2', '$emergency_address_2');";

    if (mysqli_query($connect, $query)) {
        if(mysqli_query($connect, $query_2)){
            http_response_code(200);
            echo json_encode(
                array(
                    "StatusCode" => 200,
                    'Status' => 'Success',
                    "message" => "Success: Data inserted successfully"
                )
            );
        }
    } else {
        http_response_code(404);
        echo json_encode(
            array(
                "StatusCode" => 404,
                'Status' => 'Error',
                "message" => "Error: Unable to insert data - " . mysqli_error($connect)
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