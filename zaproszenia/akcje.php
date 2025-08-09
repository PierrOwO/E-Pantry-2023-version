<?php
header('Content-type: text/html; charset=utf-8');
include('../classy.php');
$data = date('d.m.Y, H:i:s');
$result = array();
// AKCJE
if (isset($_POST['dodajDoBazy'])){
    $haslo = $_POST['haslo'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    
    $idDom = $_POST['dom_id'];
    $nazwaDom = $_POST['dom_name'];
    
    $password = $haslo;
     $salt = sha1(rand());
     $salt = substr($salt, 0, 10);
     $encrypted_password = password_hash($password.$salt, PASSWORD_DEFAULT);
    $time = date("Y.m.d, H:i:s");
 	$unique_id = uniqid('', true);
 	if(!empty($haslo) && !empty($name)){
    
 	$sql = "INSERT INTO dom_users
 	SET 
 	unique_id ='$unique_id',
 	name ='$name',
    email = '$email',
    encrypted_password = '$encrypted_password',
    salt = '$salt',
    created_at = '$time'";
    if(mysqli_query($con,$sql)){
                $result["status"] = true;
                $result["message"] = "Konto utworzone pomyślnie";
                $sql_insert = "INSERT INTO dom_moja_spizarnia_users SET unique_id = '$unique_id', id_spizarni = '$idDom'";
                    if(mysqli_query($con,$sql_insert)){
                $sql_update = "UPDATE dom_aplikacja_zaproszenia SET status = '1' WHERE unique_id = '$unique_id' AND id_spizarni = '$idDom'";
                    if(mysqli_query($con,$sql_update)){}
                $sql_update2 = "UPDATE dom_app_invition SET status = '1' WHERE email = '$email' AND dom_id = '$idDom'";
                    if(mysqli_query($con,$sql_update2)){}
                    }
                }else{
                    $result["status"] = false;
                    $result["message"] = "Błąd wysyłania, dane: ";
                }
        
    }else{
        $result["status"] = false;
        $result["message"] = "Wypełnij wszystkie dane";
    }
    echo json_encode($result);
    exit(0);
}


?>