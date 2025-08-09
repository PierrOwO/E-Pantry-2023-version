<?php
header('Content-type: text/html; charset=utf-8');
include('../data/php/classy.php');
$response = array();

if(isset($_POST['newValue'])){
$table = "system_ustawienia_menu";
$newValue = $_POST['newValue'];
if(isset($_POST['esNewEdycja'])){
$column = "edycja";
}elseif(isset($_POST['esNewHistoria'])){
$column = "historia";
}elseif(isset($_POST['esNewZakoncz'])){
$column = "zakoncz";
}elseif(isset($_POST['esNewAnuluj'])){
$column = "anuluj";
}elseif(isset($_POST['esNewUsun'])){
$column = "usun";
}elseif(isset($_POST['esNewPrzywroc'])){
$column = "column";
}elseif(isset($_POST['esNewAktualizacja'])){
$column = "aktualizuj";
}elseif(isset($_POST['esNewPozycje'])){
$column = "pozycje";
}elseif(isset($_POST['esNewEtykiety'])){
$column = "etykiety";
}elseif(isset($_POST['esNewZamowienie'])){
$column = "zamowienie";
}elseif(isset($_POST['esNewDd'])){
$column = "dd";
}elseif(isset($_POST['esNewDdw'])){
$column = "ddw";
}elseif(isset($_POST['esNewZmianaStatusu'])){
$column = "zmiana_statusu";
}elseif(isset($_POST['esNewWydawanie'])){
$column = "wydawanie";
}elseif(isset($_POST['esNewStanowiska'])){
$column = "stanowiska";
}

    $sql = "SELECT * FROM $table WHERE unique_id = '$u_id'";
    $result = $con->query($sql);
    if ($result->num_rows >0) {
        $insert = "INSERT INTO $table SET $column = '$newValue', unique_id = '$u_id'";
        if(mysqli_query($con,$insert)){
            $response["result"] = "success";
        }else{
            $response["result"] = "failure";
            $response["message"] = "Błąd #1";
        }
    }else{
        $update = "UPDATE $table SET $column = '$newValue' WHERE unique_id = '$u_id'";
        if(mysqli_query($con,$update)){
            $response["result"] = "success";
        }else{
            $response["result"] = "failure";
            $response["message"] = "Błąd #2";
        }
    }
}
echo json_encode($response);
    exit(0);
?>