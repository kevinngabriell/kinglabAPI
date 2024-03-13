<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $permission_id = $_GET['permission_id'];

    $query = "SELECT attachment
    FROM permission_log
    WHERE id_permission = '$permission_id';";

    $result = $connect->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $attachment = $row['attachment'];

        if (!empty($attachment)) {
            // Set the appropriate headers for file download
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="downloaded_file.txt"'); // You can set the desired filename
            header('Content-Length: ' . strlen($attachment));

            // Output the file content to the response
            echo $attachment;
            exit;
        } else {
            http_response_code(400);
            echo json_encode(
                array(
                    'StatusCode' => 400,
                    'Status' => 'Error',
                    'Message' => 'Attachment not found or empty.',
                )
            );
        }
    } else {
        http_response_code(404);
        echo json_encode(
            array(
                'StatusCode' => 404,
                'Status' => 'Error',
                'Message' => 'Permission not found.',
            )
        );
    }
} else {
    http_response_code(404);
    echo json_encode(
        array(
            'StatusCode' => 404,
            'Status' => 'Error',
            'Message' => 'Please check your method request.',
        )
    );
}

?>
