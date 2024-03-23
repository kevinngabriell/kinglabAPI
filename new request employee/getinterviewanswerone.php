<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id_applicant = $_GET['id_applicant'];

    $query_one = "SELECT question_score as one FROM interview WHERE applicant_id = '$id_applicant' AND question = 1;";
    $result_one = $connect->query($query_one);
    $hasilSatu = array();
    while($row_one = $result_one->fetch_assoc()){
        $hasilSatu[] = $row_one;
    }

    $query_two = "SELECT question_score as two FROM interview WHERE applicant_id = '$id_applicant' AND question = 2;";
    $result_two = $connect->query($query_two);
    $hasilDua = array();
    while($row_two = $result_two->fetch_assoc()){
        $hasilDua[] = $row_two;
    }

    $query_three = "SELECT question_score as three FROM interview WHERE applicant_id = '$id_applicant' AND question = 3;";
    $result_three = $connect->query($query_three);
    $hasilTiga = array();
    while($row_three = $result_three->fetch_assoc()){
        $hasilTiga[] = $row_three;
    }

    $query_four = "SELECT question_score as four FROM interview WHERE applicant_id = '$id_applicant' AND question = 4;";
    $result_four = $connect->query($query_four);
    $hasilEmpat = array();
    while($row_four = $result_four->fetch_assoc()){
        $hasilEmpat[] = $row_four;
    }

    $query_five = "SELECT question_score as five FROM interview WHERE applicant_id = '$id_applicant' AND question = 5;";
    $result_five = $connect->query($query_five);
    $hasilLima = array();
    while($row_five = $result_five->fetch_assoc()){
        $hasilLima[] = $row_five;
    }

    $query_six = "SELECT question_score as six FROM interview WHERE applicant_id = '$id_applicant' AND question = 6;";
    $result_six = $connect->query($query_six);
    $hasilEnam = array();
    while($row_six = $result_six->fetch_assoc()){
        $hasilEnam[] = $row_six;
    }

    $query_seven = "SELECT question_score as seven FROM interview WHERE applicant_id = '$id_applicant' AND question = 7;";
    $result_seven = $connect->query($query_seven);
    $hasilTujuh = array();
    while($row_seven = $result_seven->fetch_assoc()){
        $hasilTujuh[] = $row_seven;
    }

    $query_eight = "SELECT notes FROM interview WHERE applicant_id = '$id_applicant' AND question_score = 0;";
    $result_eight = $connect->query($query_eight);
    $hasilDelapan = array();
    while($row_eight = $result_eight->fetch_assoc()){
        $hasilDelapan[] = $row_eight;
    }

    $query_nine = "SELECT second_notes FROM interview WHERE applicant_id = '$id_applicant' AND question_score = 0;";
    $result_nine = $connect->query($query_nine);
    $hasilSembilan = array();
    while($row_nine = $result_nine->fetch_assoc()){
        $hasilSembilan[] = $row_nine;
    }
    
    echo json_encode(
        array(
            'StatusCode' => 200,
            'Status' => 'Success',
            'Data' => [
                'hasilPertama' => $hasilSatu[0]['one'],
                'hasilKedua' => $hasilDua[0]['two'],
                'hasilKetiga' => $hasilTiga[0]['three'],
                'hasilKeempat' => $hasilEmpat[0]['four'],
                'hasilKelima' => $hasilLima[0]['five'],
                'hasilKeenam' => $hasilEnam[0]['six'],
                'hasilKetujuh' => $hasilTujuh[0]['seven'],
                'hasilKedelapan' => $hasilDelapan[0]['notes'],
                'hasilKesembilan' => $hasilSembilan[0]['second_notes'],
            ]
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