<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../../connection/connection.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    // Sanitize and prepare the data
    $employee_address_ktp = $_POST['employee_address_ktp'];
    $employee_address_status_ktp = $_POST['employee_address_status_ktp'];
    $employee_rt_ktp = $_POST['employee_rt_ktp'];
    $employee_rw_ktp = $_POST['employee_rw_ktp'];
    $employee_provinsi_ktp = $_POST['employee_provinsi_ktp'];
    $employee_kota_kab_ktp = $_POST['employee_kota_kab_ktp'];
    $employee_kec_ktp = $_POST['employee_kec_ktp'];
    $employee_kel_ktp = $_POST['employee_kel_ktp'];
    $employee_address_now = $_POST['employee_address_now'];
    $employee_address_status_now = $_POST['employee_address_status_now'];
    $employee_rt_now = $_POST['employee_rt_now'];
    $employee_rw_now = $_POST['employee_rw_now'];
    $employee_provinsi_now = $_POST['employee_provinsi_now'];
    $employee_kot_kab_now = $_POST['employee_kot_kab_now'];
    $employee_kec_now = $_POST['employee_kec_now'];
    $employee_kel_now = $_POST['employee_kel_now'];
    $employee_email = $_POST['employee_email'];
    $employee_phone_number = $_POST['employee_phone_number'];
    $id = $_POST['id'];

    // Perform the insertion query
    $query = "UPDATE employee_contact_details_db SET employee_address_ktp = '$employee_address_ktp', employee_address_status_ktp = '$employee_address_status_ktp',
    employee_rt_ktp = '$employee_rt_ktp', employee_rw_ktp = '$employee_rw_ktp', employee_provinsi_ktp = '$employee_provinsi_ktp', employee_kota_kab_ktp = '$employee_kota_kab_ktp',
    employee_kec_ktp = '$employee_kec_ktp', employee_kel_ktp = '$employee_kel_ktp', employee_address_now = '$employee_address_now', employee_address_status_now = '$employee_address_status_now',
    employee_rt_now = '$employee_rt_now', employee_rw_now = '$employee_rw_now', employee_provinsi_now = '$employee_provinsi_now', employee_kot_kab_now = '$employee_kot_kab_now',
    employee_kec_now = '$employee_kec_now', employee_kel_now = '$employee_kel_now', employee_email = '$employee_email', employee_phone_number = '$employee_phone_number'  WHERE id = '$id'";

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