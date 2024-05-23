<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $action = $_GET['action'];

    if($action == '1'){
        $employeeId = $_GET['employee_id'];

        $sql = "SELECT A1.id, A1.employee_id, A1.employee_name, A2.gender_name, A1.employee_pob, A1.employee_dob, A3.nationality, A4.company_name, A5.position_name, A6.department_name, A1.employee_identity, A1.employee_jamsostek, A7.status_name, A8.religion_name
        FROM employee A1 
        LEFT JOIN gender_db A2 ON A1.gender = A2.gender_id
        LEFT JOIN nationality_db A3 ON A1.employee_nationality = A3.num_code
        LEFT JOIN company A4 ON A4.company_id = A1.company_id
        LEFT JOIN position_db A5 ON A1.position_id = A5.position_id
        LEFT JOIN department A6 ON A1.department_id = A6.department_id
        LEFT JOIN status_db A7 ON A1.employee_status = A7.status_id
        LEFT JOIN religion_db A8 ON A1.employee_religion = A8.religion_id
        WHERE A1.id = '$employeeId';";
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
    } else if ($action == '2'){
        $employeeId = $_GET['employee_id'];

        $sql = "SELECT A1.employee_address_ktp, A3.address_status_name as statusKTP, A2.name as provinsi_ktp, A4.name as kota_ktp, A1.employee_rt_ktp, A1.employee_rw_ktp, A5.name as kecamatan_ktp, A6.name as kelurahan_ktp, A1.employee_address_now, A7.address_status_name as statusDomisili, A8.name as provinsi_domisili, A9.name as kota_domisili, A10.name as kel_domisili, A11.name as kec_domisili, A1.employee_email, A1.employee_phone_number, A1.employee_rt_now, A1.employee_rw_now
FROM employee_contact_details_db A1
LEFT JOIN provinsi_db A2 ON A1.employee_provinsi_ktp = A2.id
LEFT JOIN address_status_db A3 ON A1.employee_address_status_ktp = A3.address_status_id
LEFT JOIN kotakab_db A4 ON A1.employee_kota_kab_ktp = A4.id
LEFT JOIN kecamatan_db A5 ON A1.employee_kec_ktp = A5.id
LEFT JOIN kelurahan_db A6 ON A1.employee_kel_ktp = A6.id
LEFT JOIN address_status_db A7 ON A1.employee_address_status_now = A7.address_status_id
LEFT JOIN provinsi_db A8 ON A1.employee_provinsi_now = A8.id
LEFT JOIN kotakab_db A9 ON A1.employee_kot_kab_now = A9.id
LEFT JOIN kelurahan_db A10 ON A1.employee_kel_now = A10.id
LEFT JOIN kecamatan_db A11 ON A1.employee_kec_now = A11.id
        WHERE A1.id = '$employeeId';";
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
    } else if ($action == '3'){
        $employeeId = $_GET['employee_id'];

        $sql = "SELECT * FROM employee_employement_history WHERE `index` = 1 AND id = '$employeeId';";
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
    } else if ($action == '4'){
        $employeeId = $_GET['employee_id'];

        $sql = "SELECT * FROM employee_employement_history WHERE `index` = 2 AND id = '$employeeId';";
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
    } else if ($action == '5'){
        $employeeId = $_GET['employee_id'];

        $sql = "SELECT * FROM employee_employement_history WHERE `index` = 3 AND id = '$employeeId';";
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
    } else if ($action == '6'){
        $employeeId = $_GET['employee_id'];

        $sql = "SELECT A2.education_name, A1.emp_name, A1.emp_major, A1.emp_grade, A1.emp_start, A1.emp_end, A1.emp_desc FROM employee_education_history A1 LEFT JOIN education_db A2 ON A1.emp_edu_id = A2.education_id WHERE A1.index = 1 AND A1.id = '$employeeId';";
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
    } else if ($action == '7'){
        $employeeId = $_GET['employee_id'];

        $sql = "SELECT A2.education_name, A1.emp_name, A1.emp_major, A1.emp_grade, A1.emp_start, A1.emp_end, A1.emp_desc FROM employee_education_history A1 LEFT JOIN education_db A2 ON A1.emp_edu_id = A2.education_id WHERE A1.index = 2 AND A1.id = '$employeeId';";
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
    } else if ($action == '8'){
        $employeeId = $_GET['employee_id'];

        $sql = "SELECT A2.education_name, A1.emp_name, A1.emp_major, A1.emp_grade, A1.emp_start, A1.emp_end, A1.emp_desc FROM employee_education_history A1 LEFT JOIN education_db A2 ON A1.emp_edu_id = A2.education_id WHERE A1.index = 3 AND A1.id = '$employeeId';";
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
    } else if ($action == '9'){
        $employeeId = $_GET['employee_id'];

        $sql = "SELECT A2.education_name, A1.emp_name, A1.emp_major, A1.emp_grade, A1.emp_start, A1.emp_end, A1.emp_desc FROM employee_education_history A1 LEFT JOIN education_db A2 ON A1.emp_edu_id = A2.education_id WHERE A1.index = 4 AND A1.id = '$employeeId';";
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
    } else if ($action == '10'){
        $employeeId = $_GET['employee_id'];

        $sql = "SELECT A2.education_name, A1.emp_name, A1.emp_major, A1.emp_grade, A1.emp_start, A1.emp_end, A1.emp_desc FROM employee_education_history A1 LEFT JOIN education_db A2 ON A1.emp_edu_id = A2.education_id WHERE A1.index = 5 AND A1.id = '$employeeId';";
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
    } else if ($action == '11'){
        $employeeId = $_GET['employee_id'];

        $sql = "SELECT A1.language_name, A2.ability_name as mendengar_satu, A3.ability_name as berbicara_satu, A4.ability_name as membaca_satu, A5.ability_name as menulis_satu FROM employee_language_professional A1 
LEFT JOIN ability_db A2 ON A1.listening_ability = A2.ability_id
LEFT JOIN ability_db A3 ON A1.speaking_ability = A3.ability_id
LEFT JOIN ability_db A4 ON A1.reading_ability = A4.ability_id
LEFT JOIN ability_db A5 ON A1.writing_ability = A5.ability_id WHERE A1.index = 1 AND A1.id = '$employeeId';";
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
    } else if ($action == '12'){
        $employeeId = $_GET['employee_id'];

        $sql = "SELECT A1.language_name, A2.ability_name as mendengar_dua, A3.ability_name as berbicara_dua, A4.ability_name as membaca_dua, A5.ability_name as menulis_dua FROM employee_language_professional A1 
LEFT JOIN ability_db A2 ON A1.listening_ability = A2.ability_id
LEFT JOIN ability_db A3 ON A1.speaking_ability = A3.ability_id
LEFT JOIN ability_db A4 ON A1.reading_ability = A4.ability_id
LEFT JOIN ability_db A5 ON A1.writing_ability = A5.ability_id WHERE A1.index = 2 AND A1.id = '$employeeId';";
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
    } else if ($action == '13'){
        $employeeId = $_GET['employee_id'];

        $sql = "SELECT A1.language_name, A2.ability_name as mendengar_tiga, A3.ability_name as berbicara_tiga, A4.ability_name as membaca_tiga, A5.ability_name as menulis_tiga FROM employee_language_professional A1 
LEFT JOIN ability_db A2 ON A1.listening_ability = A2.ability_id
LEFT JOIN ability_db A3 ON A1.speaking_ability = A3.ability_id
LEFT JOIN ability_db A4 ON A1.reading_ability = A4.ability_id
LEFT JOIN ability_db A5 ON A1.writing_ability = A5.ability_id WHERE A1.index = 3 AND A1.id = '$employeeId';";
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
    } else if ($action == '14'){
        $employeeId = $_GET['employee_id'];

        $sql = "SELECT A1.language_name, A2.ability_name as mendengar_empat, A3.ability_name as berbicara_empat, A4.ability_name as membaca_empat, A5.ability_name as menulis_empat FROM employee_language_professional A1 
LEFT JOIN ability_db A2 ON A1.listening_ability = A2.ability_id
LEFT JOIN ability_db A3 ON A1.speaking_ability = A3.ability_id
LEFT JOIN ability_db A4 ON A1.reading_ability = A4.ability_id
LEFT JOIN ability_db A5 ON A1.writing_ability = A5.ability_id WHERE A1.index = 4 AND A1.id = '$employeeId';";
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
    } else if ($action == '15'){
        $employeeId = $_GET['employee_id'];

        $sql = "SELECT A1.family_name, A1.family_address, A1.family_pob, A1.family_dob, A1.family_job, A2.education_name, A3.family_name as type
FROM employee_family_background A1 
LEFT JOIN education_db A2 ON A1.family_last_edu = A2.education_id
LEFT JOIN family_db A3 ON A1.family_type = A3.id_family WHERE A1.index = 1 AND A1.id = '$employeeId';";
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
    } else if ($action == '16'){
        $employeeId = $_GET['employee_id'];

        $sql = "SELECT A1.family_name, A1.family_address, A1.family_pob, A1.family_dob, A1.family_job, A2.education_name, A3.family_name as type
FROM employee_family_background A1 
LEFT JOIN education_db A2 ON A1.family_last_edu = A2.education_id
LEFT JOIN family_db A3 ON A1.family_type = A3.id_family WHERE A1.index = 2 AND A1.id = '$employeeId';";
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
    } else if ($action == '17'){
        $employeeId = $_GET['employee_id'];

        $sql = "SELECT A1.family_name, A1.family_address, A1.family_pob, A1.family_dob, A1.family_job, A2.education_name, A3.family_name as type
FROM employee_family_background A1 
LEFT JOIN education_db A2 ON A1.family_last_edu = A2.education_id
LEFT JOIN family_db A3 ON A1.family_type = A3.id_family WHERE A1.index = 3 AND A1.id = '$employeeId';";
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
    } else if ($action == '18'){
        $employeeId = $_GET['employee_id'];

        $sql = "SELECT A1.family_name, A1.family_address, A1.family_pob, A1.family_dob, A1.family_job, A2.education_name, A3.family_name as type
FROM employee_family_background A1 
LEFT JOIN education_db A2 ON A1.family_last_edu = A2.education_id
LEFT JOIN family_db A3 ON A1.family_type = A3.id_family WHERE A1.index = 4 AND A1.id = '$employeeId';";
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
    } else if ($action == '19'){
        $employeeId = $_GET['employee_id'];

        $sql = "SELECT A1.family_name, A1.family_address, A1.family_pob, A1.family_dob, A1.family_job, A2.education_name, A3.family_name as type
FROM employee_family_background A1 
LEFT JOIN education_db A2 ON A1.family_last_edu = A2.education_id
LEFT JOIN family_db A3 ON A1.family_type = A3.id_family WHERE A1.index = 5 AND A1.id = '$employeeId';";
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
    } else if ($action == '20'){
        $employeeId = $_GET['employee_id'];

        $sql = "SELECT A2.job_source_name, A1.job_source_answer_exp, A1.contact_last_comp, A1.position_applied, A1.position_alternate,
        A1.expected_salary, A3.hubungan_kerja_name, A1.is_ever_award, A1.is_ever_award_exp, A1.hobby_answer, A1.is_ever_org, 
        A1.is_ever_org_exp, A1.is_day_unv, A1.is_day_unv_exp, A1.is_any_sim, A1.sim_a_end, A1.sim_c_end, A1.is_fired, A1.is_fired_exp, 
        A1.is_jailed, A1.is_jailed_exp, A1.is_sick, A1.is_sick_exp, A1.is_smoke FROM employee_question A1 
        LEFT JOIN job_source_db A2 ON A1.job_source_answer = A2.job_source_id 
        LEFT JOIN hubungan_kerja_db A3 ON A1.hubungan_kerja_answer = A3.hubungan_kerja_id WHERE A1.id = '$employeeId';";
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
    }
    
    
} else {

}