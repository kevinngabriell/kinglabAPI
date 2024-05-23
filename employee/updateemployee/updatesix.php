<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    
    // Assuming there are already rows in the database with indexes 1 to 5 for the given $id.
    // Update queries for each family member record
    for ($i = 1; $i <= 5; $i++) {
        $family_type = $_POST["family_$i"];
        $family_name = $_POST["family_name_$i"];
        $family_address = $_POST["family_address_$i"];
        $family_pob = $_POST["family_pob_$i"];
        $family_dob = $_POST["family_dob_$i"];
        $family_edu = $_POST["family_edu_$i"];
        $family_job = $_POST["family_job_$i"];

        $query = "UPDATE employee_family_background 
                  SET 
                      family_type = '$family_type',
                      family_name = '$family_name', 
                      family_address = '$family_address', 
                      family_pob = '$family_pob', 
                      family_dob = '$family_dob', 
                      family_last_edu = '$family_edu', 
                      family_job = '$family_job'
                  WHERE id = '$id' AND `index` = $i;";

        if (!mysqli_query($connect, $query)) {
            http_response_code(404);
            echo json_encode(
                array(
                    "StatusCode" => 404,
                    'Status' => 'Error',
                    "message" => "Error: Unable to update data - " . mysqli_error($connect)
                )
            );
            exit; // Stop execution if any query fails
        }
    }

    // If all updates are successful
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
            "message" => "Error: Invalid method. Only POST requests are allowed."
        )
    );
}

?>
