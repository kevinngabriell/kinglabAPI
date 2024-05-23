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
    
    $query_one = "UPDATE employee_education_history
    SET 
        emp_edu_id = '$education_type_1',
        emp_name = '$education_name_1', 
        emp_major = '$education_major_1', 
        emp_grade = '$education_grade_1', 
        emp_start = '$education_start_1', 
        emp_end = '$education_end_1', 
        emp_desc = '$education_desc_1'
    WHERE id = '$id' AND `index` = 1;";

    $query_two = "INSERT INTO employee_education_history (id, emp_edu_id, emp_name, emp_major, emp_grade, emp_start, emp_end, emp_desc, `index`) 
VALUES ('$id', '$education_type_2','$education_name_2', '$education_major_2', '$education_grade_2', '$education_start_2', '$education_end_2', '$education_desc_2', 2);";

$query_three = "INSERT INTO employee_education_history (id, emp_edu_id, emp_name, emp_major, emp_grade, emp_start, emp_end, emp_desc, `index`) 
VALUES ('$id', '$education_type_3', '$education_name_3', '$education_major_3', '$education_grade_3', '$education_start_3', '$education_end_3', '$education_desc_3', 3);";

$query_four = "INSERT INTO employee_education_history (id, emp_edu_id, emp_name, emp_major, emp_grade, emp_start, emp_end, emp_desc, `index`) 
VALUES ('$id', '$education_type_4', '$education_name_4', '$education_major_4', '$education_grade_4', '$education_start_4', '$education_end_4', '$education_desc_4', 4);";

$query_five = "INSERT INTO employee_education_history (id, emp_edu_id, emp_name, emp_major, emp_grade, emp_start, emp_end, emp_desc, `index`) 
VALUES ('$id', '$education_type_5', '$education_name_5', '$education_major_5', '$education_grade_5', '$education_start_5', '$education_end_5', '$education_desc_5', 5);";


    if (mysqli_query($connect, $query_one) && mysqli_query($connect, $query_two) && mysqli_query($connect, $query_three) && mysqli_query($connect, $query_four) && mysqli_query($connect, $query_five)) {
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