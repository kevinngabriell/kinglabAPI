<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $education_type_1 = $_POST['education_type_1'];
    $education_name_1 = $_POST['education_name_1'];
    $education_major_1 = $_POST['education_major_1'];
    $education_grade_1 = $_POST['education_grade_1'];
    $education_start_1 = $_POST['education_start_1'];
    $education_end_1 = $_POST['education_end_1'];
    $education_desc_1 = $_POST['education_desc_1'];

    $education_type_2 = $_POST['education_type_2'];
    $education_name_2 = $_POST['education_name_2'];
    $education_major_2 = $_POST['education_major_2'];
    $education_grade_2 = $_POST['education_grade_2'];
    $education_start_2 = $_POST['education_start_2'];
    $education_end_2 = $_POST['education_end_2'];
    $education_desc_2 = $_POST['education_desc_2'];

    $education_type_3 = $_POST['education_type_3'];
    $education_name_3 = $_POST['education_name_3'];
    $education_major_3 = $_POST['education_major_3'];
    $education_grade_3 = $_POST['education_grade_3'];
    $education_start_3 = $_POST['education_start_3'];
    $education_end_3 = $_POST['education_end_3'];
    $education_desc_3 = $_POST['education_desc_3'];

    $education_type_4 = $_POST['education_type_4'];
    $education_name_4 = $_POST['education_name_4'];
    $education_major_4 = $_POST['education_major_4'];
    $education_grade_4 = $_POST['education_grade_4'];
    $education_start_4 = $_POST['education_start_4'];
    $education_end_4 = $_POST['education_end_4'];
    $education_desc_4 = $_POST['education_desc_4'];

    $education_type_5 = $_POST['education_type_5'];
    $education_name_5 = $_POST['education_name_5'];
    $education_major_5 = $_POST['education_major_5'];
    $education_grade_5 = $_POST['education_grade_5'];
    $education_start_5 = $_POST['education_start_5'];
    $education_end_5 = $_POST['education_end_5'];
    $education_desc_5 = $_POST['education_desc_5'];

    $queries = [];

    for ($i = 1; $i <= 5; $i++) {
        ${"query_$i"} = "UPDATE employee_education_history
        SET 
            emp_edu_id = '" . ${"education_type_$i"} . "',
            emp_name = '" . ${"education_name_$i"} . "', 
            emp_major = '" . ${"education_major_$i"} . "', 
            emp_grade = '" . ${"education_grade_$i"} . "', 
            emp_start = '" . ${"education_start_$i"} . "', 
            emp_end = '" . ${"education_end_$i"} . "', 
            emp_desc = '" . ${"education_desc_$i"} . "'
        WHERE id = '$id' AND `index` = $i;";

        $queries[] = ${"query_$i"};
    }

    $success = true;
    foreach ($queries as $query) {
        if (!mysqli_query($connect, $query)) {
            $success = false;
            break;
        }
    }

    if ($success) {
        http_response_code(200);
        echo json_encode(
            array(
                "StatusCode" => 200,
                'Status' => 'Success',
                "message" => "Success: Data updated successfully"
            )
        );
    } else {
        http_response_code(404);
        echo json_encode(
            array(
                "StatusCode" => 404,
                'Status' => 'Error',
                "message" => "Error: Unable to update data - " . mysqli_error($connect)
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
