<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $month = $_GET['month'];
    $year = $_GET['year'];

    $query = "SELECT A1.employee_name, A2.month, A2.year, A2.is_complete
    FROM employee A1
    LEFT JOIN salary_transaction A2 ON A1.id = A2.employee_id AND A2.month = $month AND A2.year = $year
    LEFT JOIN salary_category A3 ON A2.salary_category = A3.id_salary_category
    LEFT JOIN salary_type A4 ON A3.salary_type = A4.id_salary_type
    GROUP BY A1.employee_name;";
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