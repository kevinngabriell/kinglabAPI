<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

// Message details
$sender = "0000000015";
$title = $_POST['title'];
$message = $_POST['message'];

// Query to get all employees from the database
$sql = "SELECT id FROM employee";
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $receiver = $row["id"];
        sendNotification($sender, $receiver, $message, $title);
    }
} else {
    echo "No employees found in the database";
}

$connect->close(); // Change from $conn to $connect

function sendNotification($sender, $receiver, $message, $title) {
    $id = uniqid();

    global $connect; // Add this line to access the global $connect variable

    $query = "INSERT IGNORE INTO notification_alert (id, sender, receiver, title, message, is_read, is_important, send_date) 
    VALUES ('$id', '$sender', '$receiver', '$title', '$message', '0', '0', NOW())";

    if (mysqli_query($connect, $query)) {
        http_response_code(200);
        echo json_encode(
            array(
                "StatusCode" => 200,
                'Status' => 'Success',
                "message" => "Success: Data inserted/updated successfully"
            )
        );
    } else {
        http_response_code(404);
        echo json_encode(
            array(
                "StatusCode" => 404,
                'Status' => 'Error',
                "message" => "Error: Unable to insert/update data - " . mysqli_error($connect)
            )
        );
    }
}
?>
