<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = $_POST['employee_id'];
    $employee_name = $_POST['employee_name'];
    $department_id = $_POST['department_id'];
    $position_id = $_POST['position_id'];
    $company_id = $_POST['company_id'];
    $gender = $_POST['gender'];
    $employee_pob = $_POST['employee_pob'];
    $employee_dob = $_POST['employee_dob'];
    $employee_nationality = $_POST['employee_nationality'];
    $employee_identity = $_POST['employee_identity'];
    $employee_jamsostek = $_POST['employee_jamsostek'];
    $employee_status = $_POST['employee_status'];
    $employee_religion = $_POST['employee_religion'];

    $query = "INSERT IGNORE INTO employee (employee_id, employee_name, employee_status_id, department_id, position_id, company_id, gender, employee_pob, employee_dob, employee_nationality, employee_identity, employee_jamsostek, employee_status, employee_religion) 
              VALUES ('$employee_id', '$employee_name', 'ES-HR-001', '$department_id', '$position_id', '$company_id', '$gender', '$employee_pob', '$employee_dob', '$employee_nationality', '$employee_identity', '$employee_jamsostek', '$employee_status', '$employee_religion')";

    if (mysqli_query($connect, $query)) {
        $search_id_query = "SELECT id FROM employee WHERE employee_name = '$employee_name'";
        $search_id_result = mysqli_query($connect, $search_id_query);
        $id_row = mysqli_fetch_assoc($search_id_result);
        $id = $id_row['id'];

        $check_user_query = "SELECT username FROM users WHERE employee_id = '$id'";
        $check_user_result = mysqli_query($connect, $check_user_query);

        $check_is_user_already_exist_rows = $check_user_result->fetch_assoc();
        
        if ($check_is_user_already_exist_rows !== null) {
            http_response_code(300);
            echo json_encode(array("message" => "User already exists"));
        } else {
            $employee_data_query = "SELECT DISTINCT em.employee_name, em.employee_dob, ecd.employee_email FROM employee em JOIN employee_contact_details_db ecd ON em.id = ecd.id WHERE em.id = '$id' AND ecd.employee_email IS NOT NULL;";
            $employee_data_result = mysqli_query($connect, $employee_data_query);

            if ($employee_data_rows = $employee_data_result->fetch_assoc()) {
                $employee_name = $employee_data_rows['employee_name'];
                $name_full = explode(" ", $employee_name, 2);
                $first_char = $name_full[0];

                $random_user_number = rand(1000, 9999);
                $username_set = $first_char . $random_user_number;

                $default_password = '123456';
                $password = password_hash($default_password, PASSWORD_DEFAULT);

                date_default_timezone_set('Asia/Jakarta');
                $date_now = date('Y-m-d h:i:s', time());

                $company_id_query = "SELECT employee.company_id FROM employee WHERE employee.id = '$id' ;";
                $company_id_result = $connect->query($company_id_query);

                while ($company_id_rows = $company_id_result->fetch_assoc()) {
                    $company_id = $company_id_rows['company_id'];
                }

                $insert_user_query = "INSERT IGNORE INTO users (username, password, employee_id, company_id, created_at, modified_at) VALUES ('$username_set', '$password', '$id', '$company_id', '$date_now', '$date_now')";
                $user_input_process = mysqli_query($connect, $insert_user_query);

                if ($user_input_process) {
                    http_response_code(200);
                    echo json_encode(array("message" => "User inserted successfully"));
                } else {
                    http_response_code(400);
                    echo json_encode(array("message" => "Failed to insert user"));
                }

            } else {
                http_response_code(400);
                echo json_encode(array("message" => "Failed to retrieve additional data"));
            }
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