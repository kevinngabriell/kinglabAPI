<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    
    $language_1 = 'Bahasa Indonesia';
    $ability_1 = $_POST['ability_1'];
    $ability_2 = $_POST['ability_2'];
    $ability_3 = $_POST['ability_3'];
    $ability_4 = $_POST['ability_4'];

    $language_2 = 'Bahasa Inggris';
    $ability_5 = $_POST['ability_5'];
    $ability_6 = $_POST['ability_6'];
    $ability_7 = $_POST['ability_7'];
    $ability_8 = $_POST['ability_8'];

    $language_3 = $_POST['language_3'];
    $ability_9 = $_POST['ability_9'];
    $ability_10 = $_POST['ability_10'];
    $ability_11 = $_POST['ability_11'];
    $ability_12 = $_POST['ability_12'];

    $language_4 = $_POST['language_4'];
    $ability_13 = $_POST['ability_13'];
    $ability_14 = $_POST['ability_14'];
    $ability_15 = $_POST['ability_15'];
    $ability_16 = $_POST['ability_16'];


$query_1 = "UPDATE employee_language_professional
SET 
    language_name = '$language_1', 
    listening_ability = '$ability_1', 
    speaking_ability = '$ability_2', 
    reading_ability = '$ability_3', 
    writing_ability = '$ability_4'
WHERE id = '$id' AND `index` = 1;";


$query_2 = "UPDATE employee_language_professional
SET 
    language_name = '$language_2', 
    listening_ability = '$ability_5', 
    speaking_ability = '$ability_6', 
    reading_ability = '$ability_7', 
    writing_ability = '$ability_8'
WHERE id = '$id' AND `index` = 2;";


$query_3 = "UPDATE employee_language_professional
SET 
    language_name = '$language_3', 
    listening_ability = '$ability_9', 
    speaking_ability = '$ability_10', 
    reading_ability = '$ability_11', 
    writing_ability = '$ability_12'
WHERE id = '$id' AND `index` = 3;";


$query_4 = "UPDATE employee_language_professional
SET 
    language_name = '$language_4', 
    listening_ability = '$ability_13', 
    speaking_ability = '$ability_14', 
    reading_ability = '$ability_15', 
    writing_ability = '$ability_16'
WHERE id = '$id' AND `index` = 4;";

    if (mysqli_query($connect, $query_1) && mysqli_query($connect, $query_2) && mysqli_query($connect, $query_3) && mysqli_query($connect, $query_4)) {
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