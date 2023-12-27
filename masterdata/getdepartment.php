<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $companyId = $_GET['company_id'];
    $sanitizedCompanyId = filter_var($companyId, FILTER_SANITIZE_NUMBER_INT);

    $sql = "SELECT * FROM department WHERE company_id = '$companyId'";
    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
        $departments = array();

        while ($row = $result->fetch_assoc()) {
            $departments[] = $row;
        }

        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status' => 'Success',
                'Data' => $departments
            )
        );
    } else {
        echo json_encode(
            array(
                'StatusCode' => 400,
                'Status' => 'Error Bad Request, Result not found !'
            )
        );
    }
} else {
    http_response_code(400);
    echo json_encode(
        array(
            'StatusCode' => 405,
            'Status' => 'Error',
            'Message' => 'Please check your method request'
        )
    );
}

?>