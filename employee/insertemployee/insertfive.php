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

    $query = "INSERT INTO employee_language_professional 
    (id, language_name_1, ability_1, ability_2, ability_3, ability_4, language_name_2, ability_5, ability_6, ability_7, ability_8, language_name_3, ability_9, ability_10, ability_11, ability_12, language_name_4, ability_13, ability_14, ability_15, ability_16) VALUES ('$id', '$language_1', '$ability_1', '$ability_2', '$ability_3', '$ability_4', '$language_2', '$ability_5', '$ability_6', '$ability_7', '$ability_8', '$language_3', '$ability_9', '$ability_10', '$ability_11', '$ability_12', '$language_4', '$ability_13', '$ability_14', '$ability_15', '$ability_16');";

    if (mysqli_query($connect, $query)) {
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