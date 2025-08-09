<?php
session_start();
      $Host = '';
	  $User = 'root';
	  $Db = 'db';
	  $Pass = '';
	  
    $con = mysqli_connect($Host, $User, $Pass, $Db);
    $conn = mysqli_connect($Host, $User, $Pass, $Db);
    $con->set_charset('utf8');
    $conn->set_charset('utf8');
    
    $uStatus = $_SESSION['dom_status'];
    $uID = $_SESSION['dom_id_u'];
    $uName = $_SESSION['dom_name'];
    if(isset($_SESSION['dom_id_dom'])){
            $domID = $_SESSION['dom_id_dom'];
            $domName = $_SESSION['dom_nazwa_dom'];
    }else{
        $domID = "0";
        $domName = "Spiżarnia";
    }
?>