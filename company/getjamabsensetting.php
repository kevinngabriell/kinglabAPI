<!-- SELECT * FROM company_settings WHERE Company_ID = 'COM-HR-001'; -->
<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $company_id = $GET['company_id'];

    $sql = "SELECT * FROM company_settings WHERE Company_ID = '$company_id';";
    $query = mysqli_query($connect, $sql);

    $result = array();
    while ($row = mysqli_fetch_array($query)) {
        array_push(
            $result,
            array(
                'Company_ID' => $row['Company_ID'],
                'In_Time' => $row['In_Time'],
                'Out_Time' => $row['Out_Time']
            )
        );
    }

    if ($result) {  
        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status' => 'Success',
                'Data' => $result
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

} else {
    http_response_code(405);
    echo json_encode(
        array(
            'StatusCode' => 405,
            'Status' => 'Error',
            'Message' => 'Please check your method request'
        )
    );
}

?>