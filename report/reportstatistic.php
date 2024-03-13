<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $departmentId = $_GET['departmentId'];

    if($departmentId == 'DEPT-HR-000'){
        $query_one = "SELECT COUNT(A1.id) as jumlahLaki
        FROM employee A1
        JOIN gender_db A2 ON A1.gender = A2.gender_id
        WHERE A2.gender_id = 'GEN-HR-001';";

        $query_two = "SELECT COUNT(A1.id) as jumlahPerempuan
        FROM employee A1
        JOIN gender_db A2 ON A1.gender = A2.gender_id
        WHERE A2.gender_id = 'GEN-HR-002';";

        $query_three = "SELECT COUNT(A1.id) as belumMenikah
        FROM employee A1
        JOIN status_db A2 ON A1.employee_status = A2.status_id
        WHERE A2.status_id = 'STS-HR-001';";

        $query_four = "SELECT COUNT(A1.id) as sudahMenikah
        FROM employee A1
        JOIN status_db A2 ON A1.employee_status = A2.status_id
        WHERE A2.status_id = 'STS-HR-002';";

        $query_five = "SELECT COUNT(A1.id) as agamaIslam
        FROM employee A1
        JOIN religion_db A2 ON A1.employee_religion = A2.religion_id
        WHERE A2.religion_id = 'REL-HR-001';";

        $query_six = "SELECT COUNT(A1.id) as agamaKatholik
        FROM employee A1
        JOIN religion_db A2 ON A1.employee_religion = A2.religion_id
        WHERE A2.religion_id = 'REL-HR-002';";

        $query_seven = "SELECT COUNT(A1.id) as agamaKristen
        FROM employee A1
        JOIN religion_db A2 ON A1.employee_religion = A2.religion_id
        WHERE A2.religion_id = 'REL-HR-003';";

        $query_eight = "SELECT COUNT(A1.id) as agamaBudha
        FROM employee A1
        JOIN religion_db A2 ON A1.employee_religion = A2.religion_id
        WHERE A2.religion_id = 'REL-HR-004';";

        $query_nine = "SELECT COUNT(A1.id) as agamaHindu
        FROM employee A1
        JOIN religion_db A2 ON A1.employee_religion = A2.religion_id
        WHERE A2.religion_id = 'REL-HR-005';";

        $query_ten = "SELECT COUNT(A1.id) as agamaKonghucu
        FROM employee A1
        JOIN religion_db A2 ON A1.employee_religion = A2.religion_id
        WHERE A2.religion_id = 'REL-HR-006';";
        
        $result_one = $connect->query($query_one);
        $jumlahLaki = array();
        while($row_one = $result_one->fetch_assoc()){
            $jumlahLaki[] = $row_one;
        }
        
        $result_two = $connect->query($query_two);
        $jumlahPerempuan = array();
        while($row_two = $result_two->fetch_assoc()){
            $jumlahPerempuan[] = $row_two;
        }
        
        $genderData = [
            'jumlahLaki' => $jumlahLaki[0]['jumlahLaki'],
            'jumlahPerempuan' => $jumlahPerempuan[0]['jumlahPerempuan']
        ];
        
        $result_three = $connect->query($query_three);
        $jumlahBelumMenikah = array();
        while($row_three = $result_three->fetch_assoc()){
            $jumlahBelumMenikah[] = $row_three;
        }
        
        $result_four = $connect->query($query_four);
        $jumlahMenikah = array();
        while($row_four = $result_four->fetch_assoc()){
            $jumlahMenikah[] = $row_four;
        }
        
        $menikahData = [
            'jumlahBelumMenikah' => $jumlahBelumMenikah[0]['belumMenikah'],
            'jumlahMenikah' => $jumlahMenikah[0]['sudahMenikah']
        ];

        $result_five = $connect->query($query_five);
        $jumlahIslam = array();
        while($row_five = $result_five->fetch_assoc()){
            $jumlahIslam[] = $row_five;
        }

        $result_six = $connect->query($query_six);
        $jumlahKatolik = array();
        while($row_six = $result_six->fetch_assoc()){
            $jumlahKatolik[] = $row_six;
        }

        $result_seven = $connect->query($query_seven);
        $jumlahKristen = array();
        while($row_seven = $result_seven->fetch_assoc()){
            $jumlahKristen[] = $row_seven;
        }

        $result_eight = $connect->query($query_eight);
        $jumlahBudha = array();
        while($row_eight = $result_eight->fetch_assoc()){
            $jumlahBudha[] = $row_eight;
        }

        $result_nine = $connect->query($query_nine);
        $jumlahHindu = array();
        while($row_nine = $result_nine->fetch_assoc()){
            $jumlahHindu[] = $row_nine;
        }

        $result_ten = $connect->query($query_ten);
        $jumlahKonghucu = array();
        while($row_ten = $result_ten->fetch_assoc()){
            $jumlahKonghucu[] = $row_ten;
        }

        $religionData = [
            'jumlahIslam' => $jumlahIslam[0]['agamaIslam'],
            'jumlahKristen' => $jumlahKristen[0]['agamaKristen'],
            'jumlahKatolik' => $jumlahKatolik[0]['agamaKatholik'],
            'jumlahBudha' => $jumlahBudha[0]['agamaBudha'],
            'jumlahHindu' => $jumlahHindu[0]['agamaHindu'],
            'jumlahKonghucu' => $jumlahKonghucu[0]['agamaKonghucu'],
        ];

        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status' => 'Success',
                'Data' => [
                    'Gender' => $genderData,
                    'Status' => $menikahData,
                    'Religion' => $religionData
                ]
            )
        );

    } else {
        $query_one = "SELECT COUNT(A1.id) as jumlahLaki
        FROM employee A1
        JOIN gender_db A2 ON A1.gender = A2.gender_id
        WHERE A2.gender_id = 'GEN-HR-001' AND A1.department_id = '$departmentId';";

        $query_two = "SELECT COUNT(A1.id) as jumlahPerempuan
        FROM employee A1
        JOIN gender_db A2 ON A1.gender = A2.gender_id
        WHERE A2.gender_id = 'GEN-HR-002' AND A1.department_id = '$departmentId';";

        $query_three = "SELECT COUNT(A1.id) as belumMenikah
        FROM employee A1
        JOIN status_db A2 ON A1.employee_status = A2.status_id
        WHERE A2.status_id = 'STS-HR-001' AND A1.department_id = '$departmentId';";

        $query_four = "SELECT COUNT(A1.id) as sudahMenikah
        FROM employee A1
        JOIN status_db A2 ON A1.employee_status = A2.status_id
        WHERE A2.status_id = 'STS-HR-002' AND A1.department_id = '$departmentId';";

        $query_five = "SELECT COUNT(A1.id) as agamaIslam
        FROM employee A1
        JOIN religion_db A2 ON A1.employee_religion = A2.religion_id
        WHERE A2.religion_id = 'REL-HR-001' AND A1.department_id = '$departmentId';";

        $query_six = "SELECT COUNT(A1.id) as agamaKatholik
        FROM employee A1
        JOIN religion_db A2 ON A1.employee_religion = A2.religion_id
        WHERE A2.religion_id = 'REL-HR-002' AND A1.department_id = '$departmentId';";

        $query_seven = "SELECT COUNT(A1.id) as agamaKristen
        FROM employee A1
        JOIN religion_db A2 ON A1.employee_religion = A2.religion_id
        WHERE A2.religion_id = 'REL-HR-003' AND A1.department_id = '$departmentId';";

        $query_eight = "SELECT COUNT(A1.id) as agamaBudha
        FROM employee A1
        JOIN religion_db A2 ON A1.employee_religion = A2.religion_id
        WHERE A2.religion_id = 'REL-HR-004' AND A1.department_id = '$departmentId';";

        $query_nine = "SELECT COUNT(A1.id) as agamaHindu
        FROM employee A1
        JOIN religion_db A2 ON A1.employee_religion = A2.religion_id
        WHERE A2.religion_id = 'REL-HR-005' AND A1.department_id = '$departmentId';";

        $query_ten = "SELECT COUNT(A1.id) as agamaKonghucu
        FROM employee A1
        JOIN religion_db A2 ON A1.employee_religion = A2.religion_id
        WHERE A2.religion_id = 'REL-HR-006' AND A1.department_id = '$departmentId';";
        
        $result_one = $connect->query($query_one);
        $jumlahLaki = array();
        while($row_one = $result_one->fetch_assoc()){
            $jumlahLaki[] = $row_one;
        }
        
        $result_two = $connect->query($query_two);
        $jumlahPerempuan = array();
        while($row_two = $result_two->fetch_assoc()){
            $jumlahPerempuan[] = $row_two;
        }
        
        $genderData = [
            'jumlahLaki' => $jumlahLaki[0]['jumlahLaki'],
            'jumlahPerempuan' => $jumlahPerempuan[0]['jumlahPerempuan']
        ];
        
        $result_three = $connect->query($query_three);
        $jumlahBelumMenikah = array();
        while($row_three = $result_three->fetch_assoc()){
            $jumlahBelumMenikah[] = $row_three;
        }
        
        $result_four = $connect->query($query_four);
        $jumlahMenikah = array();
        while($row_four = $result_four->fetch_assoc()){
            $jumlahMenikah[] = $row_four;
        }
        
        $menikahData = [
            'jumlahBelumMenikah' => $jumlahBelumMenikah[0]['belumMenikah'],
            'jumlahMenikah' => $jumlahMenikah[0]['sudahMenikah']
        ];

        $result_five = $connect->query($query_five);
        $jumlahIslam = array();
        while($row_five = $result_five->fetch_assoc()){
            $jumlahIslam[] = $row_five;
        }

        $result_six = $connect->query($query_six);
        $jumlahKatolik = array();
        while($row_six = $result_six->fetch_assoc()){
            $jumlahKatolik[] = $row_six;
        }

        $result_seven = $connect->query($query_seven);
        $jumlahKristen = array();
        while($row_seven = $result_seven->fetch_assoc()){
            $jumlahKristen[] = $row_seven;
        }

        $result_eight = $connect->query($query_eight);
        $jumlahBudha = array();
        while($row_eight = $result_eight->fetch_assoc()){
            $jumlahBudha[] = $row_eight;
        }

        $result_nine = $connect->query($query_nine);
        $jumlahHindu = array();
        while($row_nine = $result_nine->fetch_assoc()){
            $jumlahHindu[] = $row_nine;
        }

        $result_ten = $connect->query($query_ten);
        $jumlahKonghucu = array();
        while($row_ten = $result_ten->fetch_assoc()){
            $jumlahKonghucu[] = $row_ten;
        }

        $religionData = [
            'jumlahIslam' => $jumlahIslam[0]['agamaIslam'],
            'jumlahKristen' => $jumlahKristen[0]['agamaKristen'],
            'jumlahKatolik' => $jumlahKatolik[0]['agamaKatholik'],
            'jumlahBudha' => $jumlahBudha[0]['agamaBudha'],
            'jumlahHindu' => $jumlahHindu[0]['agamaHindu'],
            'jumlahKonghucu' => $jumlahKonghucu[0]['agamaKonghucu'],
        ];

        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status' => 'Success',
                'Data' => [
                    'Gender' => $genderData,
                    'Status' => $menikahData,
                    'Religion' => $religionData
                ]
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