<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'];

    if($action == '1'){
        $sql = "SELECT lpd_id FROM lpd ORDER BY insert_dt DESC LIMIT 1;";
        $result = $connect->query($sql);

        if ($result->num_rows > 0) {
            $employee = array();

            while ($row = $result->fetch_assoc()) {
                $employee[] = $row;
            }

            echo json_encode(
                array(
                    'StatusCode' => 200,
                    'Status' => 'Success',
                    'Data' => $employee
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
    } else if ($action == '2'){
        $employee_id = $_GET['employee_id'];

        $sql = "SELECT A1.lpd_id, A1.businesstrip_id, A4.name, A1.businesstrip_startdate, A1.businesstrip_enddate, A1.project_name, A1.cash_advanced, A1.lpd_desc, A3.employee_name, A1.insert_dt, A5.status_name
        FROM lpd A1
        LEFT JOIN businesstrip A2 ON A1.businesstrip_id = A2.businesstrip_id
        LEFT JOIN employee A3 ON A1.insert_by = A3.id
        LEFT JOIN kotakab_db A4 ON A2.city = A4.id
        LEFT JOIN businesstrip_status A5 ON A2.status = A5.status_id
        WHERE A1.insert_by = '$employee_id'
        ORDER BY A1.insert_dt DESC;";
        $result = $connect->query($sql);
        
        if ($result->num_rows > 0) {
            $employee = array();

            while ($row = $result->fetch_assoc()) {
                $employee[] = $row;
            }

            echo json_encode(
                array(
                    'StatusCode' => 200,
                    'Status' => 'Success',
                    'Data' => $employee
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

    } else if ($action == '3'){
        $sql = "SELECT A1.lpd_id, A1.businesstrip_id, A4.name, A1.businesstrip_startdate, A1.businesstrip_enddate, A1.project_name, A1.cash_advanced, A1.lpd_desc, A3.employee_name, A1.insert_dt, A5.status_name
        FROM lpd A1
        LEFT JOIN businesstrip A2 ON A1.businesstrip_id = A2.businesstrip_id
        LEFT JOIN employee A3 ON A1.insert_by = A3.id
        LEFT JOIN kotakab_db A4 ON A2.city = A4.id
        LEFT JOIN businesstrip_status A5 ON A2.status = A5.status_id
        ORDER BY A1.insert_dt DESC;";
        $result = $connect->query($sql);
        
        if ($result->num_rows > 0) {
            $employee = array();

            while ($row = $result->fetch_assoc()) {
                $employee[] = $row;
            }

            echo json_encode(
                array(
                    'StatusCode' => 200,
                    'Status' => 'Success',
                    'Data' => $employee
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
    } else if ($action == '4'){
        $businesstrip_id = $_GET['businesstrip_id'];

        $sql = "SELECT A1.lpd_id, A1.businesstrip_id, A4.name, A1.businesstrip_startdate, A1.businesstrip_enddate, A1.project_name, A1.cash_advanced, A1.lpd_desc, A3.employee_name, A1.insert_dt, A5.status_name, A6.department_name, A3.id        
        FROM lpd A1
        LEFT JOIN businesstrip A2 ON A1.businesstrip_id = A2.businesstrip_id
        LEFT JOIN employee A3 ON A1.insert_by = A3.id
        LEFT JOIN kotakab_db A4 ON A2.city = A4.id
        LEFT JOIN businesstrip_status A5 ON A2.status = A5.status_id
        LEFT JOIN department A6 ON A3.department_id = A6.department_id
        WHERE A1.businesstrip_id = '$businesstrip_id';";
        $result = $connect->query($sql);
        
        if ($result->num_rows > 0) {
            $employee = array();

            while ($row = $result->fetch_assoc()) {
                $employee[] = $row;
            }

            echo json_encode(
                array(
                    'StatusCode' => 200,
                    'Status' => 'Success',
                    'Data' => $employee
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
    } else if ($action == '5'){
        $lpd_id = $_GET['lpd_id'];

        $query_one = "SELECT A1.count_days, A1.price, A1.total
        FROM lpd_transaction A1
        WHERE A1.lpd_id = '$lpd_id' AND A1.transaction_name='Tiket Pesawat';";

        $result_one = $connect->query($query_one);
        $jumlahSatu = array();
        while($row_one = $result_one->fetch_assoc()){
            $jumlahSatu[] = $row_one;
        }

        $tiketPesawatData = [
            'count_days' => $jumlahSatu[0]['count_days'],
            'price' => $jumlahSatu[0]['price'],
            'total' => $jumlahSatu[0]['total']
        ];

        $query_two = "SELECT A1.count_days, A1.price, A1.total
        FROM lpd_transaction A1
        WHERE A1.lpd_id = '$lpd_id' AND A1.transaction_name='Hotel / Penginapan';";

        $result_two = $connect->query($query_two);
        $jumlahDua = array();
        while($row_two = $result_two->fetch_assoc()){
            $jumlahDua[] = $row_two;
        }

        $PenginapanData = [
            'count_days' => $jumlahDua[0]['count_days'],
            'price' => $jumlahDua[0]['price'],
            'total' => $jumlahDua[0]['total']
        ];

        $query_three = "SELECT A1.count_days, A1.price, A1.total
        FROM lpd_transaction A1
        WHERE A1.lpd_id = '$lpd_id' AND A1.transaction_name='Transport';";

        $result_three = $connect->query($query_three);
        $jumlahTiga = array();
        while($row_three = $result_three->fetch_assoc()){
            $jumlahTiga[] = $row_three;
        }

        $TransportData = [
            'count_days' => $jumlahTiga[0]['count_days'],
            'price' => $jumlahTiga[0]['price'],
            'total' => $jumlahTiga[0]['total']
        ];

        $query_four = "SELECT A1.count_days, A1.price, A1.total
        FROM lpd_transaction A1
        WHERE A1.lpd_id = '$lpd_id' AND A1.transaction_name='By Entertain';";

        $result_four = $connect->query($query_four);
        $jumlahEmpat = array();
        while($row_four = $result_four->fetch_assoc()){
            $jumlahEmpat[] = $row_four;
        }

        $ByEntertainData = [
            'count_days' => $jumlahEmpat[0]['count_days'],
            'price' => $jumlahEmpat[0]['price'],
            'total' => $jumlahEmpat[0]['total']
        ];

        $query_five = "SELECT A1.count_days, A1.price, A1.total
        FROM lpd_transaction A1
        WHERE A1.lpd_id = '$lpd_id' AND A1.transaction_name='Lain-lain';";

        $result_five = $connect->query($query_five);
        $jumlahLima = array();
        while($row_five = $result_five->fetch_assoc()){
            $jumlahLima[] = $row_five;
        }

        $LainLainData = [
            'count_days' => $jumlahLima[0]['count_days'],
            'price' => $jumlahLima[0]['price'],
            'total' => $jumlahLima[0]['total']
        ];

        $query_six = "SELECT A1.count_days, A1.price, A1.total
        FROM lpd_transaction A1
        WHERE A1.lpd_id = '$lpd_id' AND A1.transaction_name='Uang Saku';";

        $result_six = $connect->query($query_six);
        $jumlahEnam = array();
        while($row_six= $result_six->fetch_assoc()){
            $jumlahEnam[] = $row_six;
        }

        $UangSaku = [
            'count_days' => $jumlahEnam[0]['count_days'],
            'price' => $jumlahEnam[0]['price'],
            'total' => $jumlahEnam[0]['total']
        ];

        $query_seven = "SELECT A1.count_days, A1.price, A1.total
        FROM lpd_transaction A1
        WHERE A1.lpd_id = '$lpd_id' AND A1.transaction_name='Uang Saku 2';";

        $result_seven = $connect->query($query_seven);
        $jumlahTujuh = array();
        while($row_seven= $result_seven->fetch_assoc()){
            $jumlahTujuh[] = $row_seven;
        }

        $UangSakuDua = [
            'count_days' => $jumlahTujuh[0]['count_days'],
            'price' => $jumlahTujuh[0]['price'],
            'total' => $jumlahTujuh[0]['total']
        ];

        $query_eight = "SELECT A1.count_days, A1.price, A1.total
        FROM lpd_transaction A1
        WHERE A1.lpd_id = '$lpd_id' AND A1.transaction_name='Uang Saku 3';";

        $result_eight = $connect->query($query_eight);
        $jumlahDelapan = array();
        while($row_eight= $result_eight->fetch_assoc()){
            $jumlahDelapan[] = $row_eight;
        }

        $UangSakuTiga = [
            'count_days' => $jumlahDelapan[0]['count_days'],
            'price' => $jumlahDelapan[0]['price'],
            'total' => $jumlahDelapan[0]['total']
        ];

        $query_nine = "SELECT A1.count_days, A1.price, A1.total
        FROM lpd_transaction A1
        WHERE A1.lpd_id = '$lpd_id' AND A1.transaction_name='Uang Saku 4';";

        $result_nine = $connect->query($query_nine);
        $jumlahSembilan = array();
        while($row_nine= $result_nine->fetch_assoc()){
            $jumlahSembilan[] = $row_nine;
        }

        $UangSakuEmpat = [
            'count_days' => $jumlahSembilan[0]['count_days'],
            'price' => $jumlahSembilan[0]['price'],
            'total' => $jumlahSembilan[0]['total']
        ];

        $query_ten = "SELECT A1.count_days, A1.price, A1.total
        FROM lpd_transaction A1
        WHERE A1.lpd_id = '$lpd_id' AND A1.transaction_name='Uang Saku 5';";

        $result_ten = $connect->query($query_ten);
        $jumlahSepuluh = array();
        while($row_ten= $result_ten->fetch_assoc()){
            $jumlahSepuluh[] = $row_ten;
        }

        $UangSakuLima = [
            'count_days' => $jumlahSepuluh[0]['count_days'],
            'price' => $jumlahSepuluh[0]['price'],
            'total' => $jumlahSepuluh[0]['total']
        ];

        $query_eleven = "SELECT A1.count_days, A1.price, A1.total
        FROM lpd_transaction A1
        WHERE A1.lpd_id = '$lpd_id' AND A1.transaction_name='Uang Makan';";

        $result_eleven = $connect->query($query_eleven);
        $jumlahSebelas = array();
        while($row_eleven= $result_eleven->fetch_assoc()){
            $jumlahSebelas[] = $row_eleven;
        }

        $UangMakan = [
            'count_days' => $jumlahSebelas[0]['count_days'],
            'price' => $jumlahSebelas[0]['price'],
            'total' => $jumlahSebelas[0]['total']
        ];

        $query_twelve = "SELECT A1.count_days, A1.price, A1.total
        FROM lpd_transaction A1
        WHERE A1.lpd_id = '$lpd_id' AND A1.transaction_name='Uang Makan 2';";

        $result_twelve = $connect->query($query_twelve);
        $jumlahDuaBelas = array();
        while($row_twelve = $result_twelve->fetch_assoc()){
            $jumlahDuaBelas[] = $row_twelve;
        }

        $UangMakanDua = [
            'count_days' => $jumlahDuaBelas[0]['count_days'],
            'price' => $jumlahDuaBelas[0]['price'],
            'total' => $jumlahDuaBelas[0]['total']
        ];

        $query_thirteen = "SELECT A1.count_days, A1.price, A1.total
        FROM lpd_transaction A1
        WHERE A1.lpd_id = '$lpd_id' AND A1.transaction_name='Uang Makan 3';";

        $result_thirteen = $connect->query($query_thirteen);
        $jumlahTigaBelas = array();
        while($row_thirteen = $result_thirteen->fetch_assoc()){
            $jumlahTigaBelas[] = $row_thirteen;
        }

        $UangMakanTiga = [
            'count_days' => $jumlahTigaBelas[0]['count_days'],
            'price' => $jumlahTigaBelas[0]['price'],
            'total' => $jumlahTigaBelas[0]['total']
        ];

        $query_fourteen= "SELECT A1.count_days, A1.price, A1.total
        FROM lpd_transaction A1
        WHERE A1.lpd_id = '$lpd_id' AND A1.transaction_name='Uang Makan 4';";

        $result_fourteen = $connect->query($query_fourteen);
        $jumlahEmpatBelas = array();
        while($row_fourteen = $result_fourteen->fetch_assoc()){
            $jumlahEmpatBelas[] = $row_fourteen;
        }

        $UangMakanEmpat = [
            'count_days' => $jumlahEmpatBelas[0]['count_days'],
            'price' => $jumlahEmpatBelas[0]['price'],
            'total' => $jumlahEmpatBelas[0]['total']
        ];

        $query_fifthteen= "SELECT A1.count_days, A1.price, A1.total
        FROM lpd_transaction A1
        WHERE A1.lpd_id = '$lpd_id' AND A1.transaction_name='Uang Makan 5';";

        $result_fifthteen = $connect->query($query_fifthteen);
        $jumlahLimaBelas = array();
        while($row_fifthteen = $result_fifthteen->fetch_assoc()){
            $jumlahLimaBelas[] = $row_fifthteen;
        }

        $UangMakanLima = [
            'count_days' => $jumlahLimaBelas[0]['count_days'],
            'price' => $jumlahLimaBelas[0]['price'],
            'total' => $jumlahLimaBelas[0]['total']
        ];

        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status' => 'Success',
                'Data' => [
                    'TiketPesawat' => $tiketPesawatData,
                    'Penginapan' => $PenginapanData,
                    'Uang Saku' => $UangSaku,
                    'Uang Saku 2' => $UangSakuDua,
                    'Uang Saku 3' => $UangSakuTiga,
                    'Uang Saku 4' => $UangSakuEmpat,
                    'Uang Saku 5' => $UangSakuLima,
                    'Transport' => $TransportData,
                    'Uang Makan' => $UangMakan,
                    'Uang Makan 2' => $UangMakanDua,
                    'Uang Makan 3' => $UangMakanTiga,
                    'Uang Makan 4' => $UangMakanEmpat,
                    'Uang Makan 5' => $UangMakanLima,
                    'ByEntertain' => $ByEntertainData,
                    'LainLain' => $LainLainData
                ]
            )
        );
    } else if ($action == '6'){
        $lpd_id = $_GET['lpd_id'];

        $sql = "SELECT A2.employee_name, A1.action, A1.action_dt
        FROM lpd_log A1
        LEFT JOIN employee A2 ON A1.action_by = A2.id
        WHERE A1.lpd_id = '$lpd_id';";
        $result = $connect->query($sql);
        
        if ($result->num_rows > 0) {
            $employee = array();

            while ($row = $result->fetch_assoc()) {
                $employee[] = $row;
            }

            echo json_encode(
                array(
                    'StatusCode' => 200,
                    'Status' => 'Success',
                    'Data' => $employee
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