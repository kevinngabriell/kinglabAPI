<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $employee_id = $_GET['employee_id'];

    $query = "SELECT
        employee_id,
        leave_count,
        leave_year
    FROM (
        SELECT
            employee_id,
            YEAR(year) AS leave_year,
            leave_count
        FROM
            annual_leave
        WHERE
            employee_id = '$employee_id'
            AND (
                YEAR(year) = YEAR(CURDATE()) - 1 -- Last year
                OR YEAR(year) = YEAR(CURDATE()) -- This year
                OR YEAR(year) = YEAR(CURDATE()) + 1 -- Next year
                OR YEAR(year) = YEAR(CURDATE()) + 2 -- Next next year
            )
    ) AS subquery
    GROUP BY
        employee_id,
        leave_year
    ORDER BY
        leave_year;";
    $result = $connect->query($query);

    if($result->num_rows > 0){

        $jumlahCuti = array();

        while($row = $result->fetch_assoc()){
            $jumlahCuti[] = $row;
        }

        http_response_code(200);
        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status' => 'Success',
                'Data' => $jumlahCuti
            )
        );

    } else{
        http_response_code(400);
        echo json_encode(
            array(
                'StatusCode' => 400,
                'Status' => 'Not Found',
                "message" => "No found"
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