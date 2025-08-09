<?php
header('Content-type: text/html; charset=utf-8');
include('classy.php');
$data = date('d.m.Y, H:i:s');
$result = array();

if (isset($_POST['logout'])) {
    session_destroy();
  	unset($_SESSION['dom_id_u']);
  	unset($_SESSION['dom_id_dom']);
  	unset($_SESSION['dom_name']);
  	
  	if (isset($_COOKIE['user'])) {
    unset($_COOKIE['user']); 
    setcookie('user', '', -1, '/'); 
  	}
    
}

if (isset($_POST['dodajDoBazy'])){
    
    $id_kategorii = $_POST['id_kategorii'];
    $id_podkategorii = $_POST['id_podkategorii'];
    $nazwa_kategorii = $_POST['nazwa_kategorii'];
    $nazwa_podkategorii = $_POST['nazwa_podkategorii'];
    $nazwa_produktu = $_POST['nazwa_produktu'];
    $jednostka = $_POST['jednostka'];
    
    if(!empty($id_kategorii) && !empty($nazwa_kategorii) && !empty($nazwa_produktu)){
        $sql = "INSERT INTO dom_produkty
            SET
            nazwa = '$nazwa_produktu',
            id_kategorii = '$id_kategorii',
            id_podkategorii = '$id_podkategorii',
            nazwa_kategorii = '$nazwa_kategorii',
            nazwa_podkategorii = '$nazwa_podkategorii',
            jednostka = '$jednostka'";
                if(mysqli_query($con,$sql)){
                $result["status"] = true;
                $result["message"] = "Produkt poprawnie dodany";
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

if (isset($_POST['odejmowanieProduktu'])){
     

  $id_produktu = $_POST['produkt'];
  $ilosc = $_POST['ilosc'];

 
      $sql1 = "SELECT * FROM dom_produkty_dostepne WHERE id = '$id_produktu'";
        $result1 = $con->query($sql1);
        if ($result1->num_rows >0) {
             while($row1 = mysqli_fetch_array($result1)){
                $ilosc_baza = $row1['ilosc'];
                $id_produktu_b = $row1['id_produktu'];
            }
            $nowa_ilosc = $ilosc_baza - $ilosc;
            $ilosc_op = "-$ilosc";
            
            $sql2 = "SELECT * FROM dom_produkty WHERE id = '$id_produktu_b'";
            $result2 = $con->query($sql2);
            if ($result2->num_rows >0) {
             while($row2 = mysqli_fetch_array($result2)){
                $nazwa_produktu = $row2['nazwa'];
                $id_kategorii = $row2['id_kategorii'];
                $id_podkategorii = $row2['id_podkategorii'];
            }
            
            $sql_update = "UPDATE dom_produkty_dostepne SET ilosc = '$nowa_ilosc' WHERE id = '$id_produktu'";
            if(mysqli_query($con,$sql_update)){
                
            $sql_historia = "INSERT INTO dom_historia 
            SET 
            kto = '$uName', 
            unique_id = '$uID', 
            id_produktu = '$id_produktu_b', 
            nazwa = '$nazwa_produktu', 
            ilosc = '$ilosc_op', 
            data = '$data', 
            id_kategorii = '$id_kategorii', 
            id_podkategorii = '$id_podkategorii', 
            dom_id = '$domID'";
            if(mysqli_query($con,$sql_historia)){}
            
                $result["status"] = true;
                $result["message"] = "Sukces!";
            }else{
            $result["status"] = false;
            $result["message"] = "Błąd #1 :(";
            }
            }else{
            $result["status"] = false;
            $result["message"] = "Błąd #2 :(";
            }
        }else{
            $result["status"] = false;
            $result["message"] = "Błąd pobierania danych :(";
            }
    echo json_encode($result);
    exit(0);
} 


if (isset($_POST['dolaczDoSpizarni'])){
    
    $id_zaproszenia = $_POST['id_zaproszenia'];

        $sql2 = "SELECT * FROM dom_moja_spizarnia_zaproszenia WHERE id = '$id_zaproszenia' AND unique_id = '$uID'";
          $result2 = $con->query($sql2);
          if ($result2->num_rows >0) {
            while($row2 = mysqli_fetch_array($result2)){
                $id_spizarni = $row2['id_spizarni'];
            }
               $sql = "INSERT INTO dom_moja_spizarnia_users SET unique_id = '$uID', id_spizarni = '$id_spizarni'";
                if(mysqli_query($con,$sql)){
                    
                $sql_update = "UPDATE dom_moja_spizarnia_zaproszenia 
                    SET 
                    status = '1'
                    WHERE
                    id = '$id_zaproszenia'";
                    if(mysqli_query($con,$sql_update)){}
                    
                $result["status"] = true;
                $result["message"] = "Zaproszenie zaakceptowane!";
                
                }else{
                    $result["status"] = false;
                    $result["message"] = "Nieznany błąd :$id_zaproszenia";
                }
      }else{
          $result["status"] = false;
          $result["message"] = "Błąd wczytywania danych :$id_zaproszenia";
      }
    echo json_encode($result);
    exit(0);
}
if (isset($_POST['odmowDolaczenia'])){
    
    $id_zaproszenia = $_POST['id_zaproszenia'];
    
        $sql2 = "SELECT * FROM dom_moja_spizarnia_zaproszenia WHERE id = '$id_zaproszenia' AND unique_id = '$uID'";
          $result2 = $con->query($sql2);
            if ($result2->num_rows >0) {
            $sql_update = "UPDATE dom_moja_spizarnia_zaproszenia 
                    SET 
                    status = '1'
                    WHERE
                    id = '$id_zaproszenia'";
                    if(mysqli_query($con,$sql_update)){
                        $result["status"] = true;
                        $result["message"] = "Zaproszenie usunięte!";
                        }else{
                    $result["status"] = false;
                    $result["message"] = "Nieznany błąd ::$id_zaproszenia";
                    }
            }else{
          $result["status"] = false;
          $result["message"] = "Błąd wczytywania danych ::$id_zaproszenia";
      }
    echo json_encode($result);
    exit(0);
}

if (isset($_POST['zaprosDoSpizarni'])){
    
    $email = $_POST['email'];
    $data = date('d.m.Y');
    
        $sql2 = "SELECT * FROM dom_users WHERE email = '$email'";
          $result2 = $con->query($sql2);
          if ($result2->num_rows >0) {
            while($row2 = mysqli_fetch_array($result2)){
                $unique_id = $row2['unique_id'];
            }
               $sql = "SELECT * FROM dom_moja_spizarnia WHERE id = '$domID'";
                $result1 = $con->query($sql);
                if ($result1->num_rows >0) {
                while($row1 = mysqli_fetch_array($result1)){
                $nazwa_spizarni = $row1['nazwa'];
                }
                $sql_insert = "INSERT INTO dom_moja_spizarnia_zaproszenia 
                    SET 
                    unique_id = '$unique_id',
                    id_zapraszajacy = '$uID',
                    nazwa_zapraszajacy = '$uName',
                    id_spizarni = '$domID',
                    nazwa_spizarni = '$nazwa_spizarni',
                    data = '$data'";
                    if(mysqli_query($con,$sql_insert)){
                        $result["status"] = true;
                        $result["message"] = "Zaproszenie wysłane!";
                    }else{
                        $result["status"] = false;
                        $result["message"] = "Błąd wysyłania";
                    }
                }else{
                    $result["status"] = false;
                    $result["message"] = "Błąd wczytywania";
                }
      }else{
          $result["status"] = false;
          $result["message"] = "Nie znaleziono użytkownika";
      }
    echo json_encode($result);
    exit(0);
}

if (isset($_POST['wczytajSpizarnie'])){
     
     $id = $_POST['id_spizarni'];
     $nazwa = $_POST['nazwa_spizarni'];
            
            
        $sql2 = "SELECT * FROM dom_moja_spizarnia WHERE id = '$id'";
          $result2 = $con->query($sql2);
          if ($result2->num_rows >0) {
               $sql = "SELECT * FROM dom_moja_spizarnia_users WHERE id_spizarni = '$id' AND unique_id = '$uID'";
                $result = $con->query($sql);
                if ($result->num_rows >0) {
              session_start();
                $_SESSION['dom_id_dom'] = $id;
                $_SESSION['dom_nazwa_dom'] = $nazwa;
                
                $result["status"] = true;
                }else{
                    $result["status"] = false;
                    $result["message"] = "Nie masz dostępu do tej spiżarni";
                }
      }else{
          $result["status"] = false;
          $result["message"] = "Nie znaleziono spizarni";
      }
    echo json_encode($result);
    exit(0);
}
if (isset($_POST['nowaSpizarnia'])){
     

  $nazwa = $_POST['nazwa'];

 
      $sql = "INSERT INTO dom_moja_spizarnia SET nazwa = '$nazwa', unique_id = '$uID'";
      if(mysqli_query($con,$sql)){
          $sql2 = "SELECT * FROM dom_moja_spizarnia WHERE nazwa = '$nazwa' AND unique_id = '$uID'";
          $result2 = $con->query($sql2);
          if ($result2->num_rows >0) {
            while($row2 = mysqli_fetch_array($result2)){
            $id_spizarni = $row2['id'];
            }
            $sql3 = "INSERT INTO  dom_moja_spizarnia_users SET id_spizarni = '$id_spizarni', zalozyciel = '1', unique_id = '$uID'";
                if(mysqli_query($con,$sql3)){}
          }
          $result["status"] = true;
          $result["message"] = "Spiżarnia dodana!";
      }else{
          $result["status"] = false;
          $result["message"] = "Błąd dodawania";
      }
    echo json_encode($result);
    exit(0);
} 
 
if (isset($_POST['checkIn'])){
     

  $id_produktu = $_POST['checkIn'];
      $sql_lista = "SELECT * FROM dom_lista_zakupow_produkty WHERE id = '$id_produktu'";
        $result_lista = $con->query($sql_lista);
        if ($result_lista->num_rows >0) {
            $sql_update = "UPDATE dom_lista_zakupow_produkty SET checked = '1' WHERE id = '$id_produktu'";
            if(mysqli_query($con,$sql_update)){
                $result["status"] = true;
            }else{
            $result["status"] = false;
            }
        }else{
            $result["status"] = false;
            }
    echo json_encode($result);
    exit(0);
} 
if (isset($_POST['checkOut'])){
     

  $id_produktu = $_POST['checkOut'];
      $sql_lista = "SELECT * FROM dom_lista_zakupow_produkty WHERE id = '$id_produktu'";
        $result_lista = $con->query($sql_lista);
        if ($result_lista->num_rows >0) {
            $sql_update = "UPDATE dom_lista_zakupow_produkty SET checked = '0' WHERE id = '$id_produktu'";
            if(mysqli_query($con,$sql_update)){
                $result["status"] = true;
            }else{
            $result["status"] = false;
            }
        }else{
            $result["status"] = false;
            }
    echo json_encode($result);
    exit(0);
} 
if (isset($_POST['korekta_produktu'])){
     

  $id_produktu = $_POST['produkt'];
  $ilosc = $_POST['ilosc'];

 
      $sql_lista = "SELECT * FROM dom_lista_zakupow_produkty WHERE id = '$id_produktu'";
        $result_lista = $con->query($sql_lista);
        if ($result_lista->num_rows >0) {
            $sql_update = "UPDATE dom_lista_zakupow_produkty SET ilosc = '$ilosc' WHERE id = '$id_produktu'";
            if(mysqli_query($con,$sql_update)){
                $result["status"] = true;
                $result["message"] = "Korekta poprawnie wprowadzona";
            }else{
            $result["status"] = false;
            $result["message"] = "Błąd aktualizowania ilości";
            }
        }else{
            $result["status"] = false;
            $result["message"] = "Błąd pobierania danych";
            }
    echo json_encode($result);
    exit(0);
} 

if (isset($_POST['zamknij_liste_zakupow'])) {
  
  

$sql_lista_id = "SELECT * FROM dom_lista_zakupow WHERE dom_id = '$domID' AND status = '1'";
$result_lista_id = $con->query($sql_lista_id);
  if ($result_lista_id->num_rows >0) {
      while($row_lista_id = mysqli_fetch_array($result_lista_id)){
          $id_listy = $row_lista_id['id'];
      }
      
      $sql_lista = "SELECT * FROM dom_lista_zakupow_produkty WHERE id_listy_zakupow = '$id_listy' AND status = '0'";
        $result_lista = $con->query($sql_lista);
        if ($result_lista->num_rows >0) {
            while($row_lista = mysqli_fetch_array($result_lista)){
            $id_produktu = $row_lista['id_produktu'];
            $ilosc = $row_lista['ilosc'];
        
            $sql_status_u = "UPDATE dom_lista_zakupow_produkty SET status = '1' WHERE id_produktu = '$id_produktu'";
            if(mysqli_query($con,$sql_status_u)){}
        //start
        if($ilosc != "0"){
            $sql1 = "SELECT * FROM dom_produkty WHERE id = '$id_produktu'";
            $result1 = $con->query($sql1);
            if ($result1->num_rows >0) {
            while($row1 = mysqli_fetch_array($result1)){
	            $nazwa_produktu = $row1['nazwa'];
	            $id_kategorii = $row1['id_kategorii'];
	            $id_podkategorii = $row1['id_podkategorii'];
                }
            $sql2 = "SELECT * FROM dom_produkty_dostepne WHERE id_produktu = '$id_produktu' AND dom_id = '$domID'";
            $result2 = $con->query($sql2);
            if ($result2->num_rows >0) {
            while($row2 = mysqli_fetch_array($result2)){
	            $ilosc_produktow = $row2['ilosc'];
                }
            $nowa_ilosc_produtu = $ilosc_produktow + $ilosc;

            $sql_u = "UPDATE dom_produkty_dostepne SET ilosc = '$nowa_ilosc_produtu' WHERE id_produktu = '$id_produktu' AND dom_id = '$domID'";
            if(mysqli_query($con,$sql_u)){
 
            $sql_historia = "INSERT INTO dom_historia 
            SET 
            kto = '$uName', 
            unique_id = '$uID', 
            id_produktu = '$id_produktu', 
            nazwa = '$nazwa_produktu', 
            ilosc = '$ilosc', 
            data = '$data', 
            id_kategorii = '$id_kategorii', 
            id_podkategorii = '$id_podkategorii', 
            dom_id = '$domID'";
            if(mysqli_query($con,$sql_historia)){}
            }
    
            }else{
            $sql_i = "INSERT INTO dom_produkty_dostepne
            SET
            id_produktu = '$id_produktu',
            ilosc = '$ilosc',
            nazwa = '$nazwa_produktu', 
            dom_id = '$domID'";
            if(mysqli_query($con,$sql_i)){
        
            $sql_historia = "INSERT INTO dom_historia 
            SET 
            kto = '$uName', 
            unique_id = '$uID', 
            id_produktu = '$id_produktu', 
            nazwa = '$nazwa_produktu', 
            ilosc = '$ilosc', 
            data = '$data', 
            id_kategorii = '$id_kategorii', 
            id_podkategorii = '$id_podkategorii', 
            dom_id = '$domID'";
            if(mysqli_query($con,$sql_historia)){}
            }
            }
           
            } 
        //koniec
        }
        

            }
            while (true) {
                $Sql = "SELECT * FROM dom_lista_zakupow_produkty WHERE status = '0' AND id_listy_zakupow = '$id_listy'";
                $result_wartosc = $con->query($Sql);
                if ($result_wartosc->num_rows == 0) {
                $sql_u = "UPDATE dom_lista_zakupow SET status = '0' WHERE id = '$id_listy'";
                if(mysqli_query($con,$sql_u)){}
                break;
                }
            }
            $result["status"] = true;
            $result["message"] = "sukces";
               
        }else{
            $result["status"] = false;
            $result["message"] = "błąd2";
            }
        
        
  }else{
        $result["status"] = false;
        $result["message"] = "błąd pobierania danych";
        }
  


echo json_encode($result);
exit(0);
}




if (isset($_POST['zatwierdzDodawanieProduktu'])) {
  
  
  
  $ilosc= $_POST['ilosc'];
  $id_produktu = $_POST['produkt'];

if(!empty($ilosc) && $id_produktu != "-1"){

$sql1 = "SELECT * FROM dom_produkty WHERE id = '$id_produktu'";
  $result1 = $con->query($sql1);
  if ($result1->num_rows >0) {
     while($row1 = mysqli_fetch_array($result1)){
	$nazwa_produktu = $row1['nazwa'];
	$id_kategorii = $row1['id_kategorii'];
	$id_podkategorii = $row1['id_podkategorii'];
}
$sql2 = "SELECT * FROM dom_produkty_dostepne WHERE id_produktu = '$id_produktu' AND dom_id = '$domID'";
$result2 = $con->query($sql2);
if ($result2->num_rows >0) {
     while($row2 = mysqli_fetch_array($result2)){
	$ilosc_produktow = $row2['ilosc'];
}
$nowa_ilosc_produtu = $ilosc_produktow + $ilosc;

$sql_u = "UPDATE dom_produkty_dostepne SET ilosc = '$nowa_ilosc_produtu' WHERE id_produktu = '$id_produktu'";
if(mysqli_query($con,$sql_u)){
 
 $sql_historia = "INSERT INTO dom_historia 
    SET 
    kto = '$uName', 
    unique_id = '$uID', 
    id_produktu = '$id_produktu', 
    nazwa = '$nazwa_produktu', 
    ilosc = '$ilosc', 
    data = '$data', 
    id_kategorii = '$id_kategorii', 
    id_podkategorii = '$id_podkategorii', 
    dom_id = '$domID'";
    if(mysqli_query($con,$sql_historia)){}
    
    $result["status"] = true;
    $result["message"] = "Ilość produktu '$nazwa_produktu' została poprawnie zaktualizowana";
    }
    
}else{
    $sql_i = "INSERT INTO dom_produkty_dostepne
    SET
    id_produktu = '$id_produktu',
    ilosc = '$ilosc',
    nazwa = '$nazwa_produktu', 
    dom_id = '$domID'";
    if(mysqli_query($con,$sql_i)){
        
    $sql_historia = "INSERT INTO dom_historia 
    SET 
    kto = '$uName', 
    unique_id = '$uID', 
    id_produktu = '$id_produktu', 
    nazwa = '$nazwa_produktu', 
    ilosc = '$ilosc', 
    data = '$data', 
    id_kategorii = '$id_kategorii', 
    id_podkategorii = '$id_podkategorii', 
    dom_id = '$domID'";
    if(mysqli_query($con,$sql_historia)){}
    
    
    $result["status"] = true;
    $result["message"] = "Produkt '$nazwa_produktu' poprawnie dodany do spiżarni";
    }
    
}
}else{
    $result["status"] = false;
    $result["message"] = "Błąd dodawania produktu";
}
}else{
     $result["status"] = false;
     $result["message"] = "Wypełnij wszystkie pola";
 }
 echo json_encode($result);
            exit(0);
}

if (isset($_POST['dodaj_produkt_do_listy'])) {
  
  
  
  $ilosc= $_POST['ilosc'];
  $id_produktu = $_POST['produkt'];

if(!empty($ilosc) && $id_produktu != "-1"){
$sql_lista = "SELECT * FROM dom_lista_zakupow WHERE dom_id = '$domID' AND status = '1'";
  $result_lista = $con->query($sql_lista);
  if ($result_lista->num_rows >0) {
      while($row_lista = mysqli_fetch_array($result_lista)){
      $id_listy_zakupow = $row_lista['id'];
      }}else{
          while (true) {
            $numer1= date("y/m/d");
            $numer2 = substr(str_shuffle(str_repeat("0123456789", 4)), 0, 4);
            $numer = "$numer1/$numer2";
            $Sql = "SELECT * FROM dom_lista_zakupow WHERE numer = '$numer' AND dom_id = '$domID'";
            $result_wartosc = $con->query($Sql);
            if ($result_wartosc->num_rows == 0) {
            break;
            }
          }
    $sql_i_lista = "INSERT INTO dom_lista_zakupow
    SET
    numer = '$numer',
    dom_id = '$domID',
    status = '1'";
    if(mysqli_query($con,$sql_i_lista)){
        $sql_lista2 = "SELECT * FROM dom_lista_zakupow WHERE dom_id = '$domID' AND status = '1'";
        $result_lista2 = $con->query($sql_lista2);
        if ($result_lista2->num_rows >0) {
            while($row_lista2 = mysqli_fetch_array($result_lista2)){
                $id_listy_zakupow = $row_lista2['id'];
            }
        }
    }
}
$sql1 = "SELECT * FROM dom_produkty WHERE id = '$id_produktu'";
  $result1 = $con->query($sql1);
  if ($result1->num_rows >0) {
     while($row1 = mysqli_fetch_array($result1)){
	$nazwa_produktu = $row1['nazwa'];
	$nazwa_kategorii = $row1['nazwa_kategorii'];
	$nazwa_podkategorii = $row1['nazwa_podkategorii'];
	$id_kategorii = $row1['id_kategorii'];
	$id_podkategorii = $row1['id_podkategorii'];
	$jednostka = $row1['jednostka'];
}
$sql2 = "SELECT * FROM dom_lista_zakupow_produkty WHERE id_produktu = '$id_produktu' AND id_listy_zakupow = '$id_listy_zakupow'";
  $result2 = $con->query($sql2);
  if ($result2->num_rows >0) {
      while($row2 = mysqli_fetch_array($result2)){
          $ilosc_b = $row2['ilosc'];
      }
      $nowa_ilosc = $ilosc_b + $ilosc;
    $sql_i = "UPDATE dom_lista_zakupow_produkty
    SET
    ilosc = '$nowa_ilosc', 
    data = '$data', 
    unique_id = '$uID'
    WHERE
    id_produktu = '$id_produktu'
    AND
    id_listy_zakupow = '$id_listy_zakupow'";
    if(mysqli_query($con,$sql_i)){
    $result["status"] = true;
    $result["message"] = "Produkt poprawnie dodany do listy zakupów";
    }else{
    $result["status"] = false;
    $result["message"] = "Błąd dodawania";}
  }else{
      $sql_i = "INSERT INTO dom_lista_zakupow_produkty
    SET
    id_produktu = '$id_produktu',
    nazwa_produktu = '$nazwa_produktu', 
    nazwa_kategorii = '$nazwa_kategorii', 
    nazwa_podkategorii = '$nazwa_podkategorii', 
    id_kategorii = '$id_kategorii', 
    id_podkategorii = '$id_podkategorii', 
    ilosc = '$ilosc', 
    data = '$data', 
    unique_id = '$uID', 
    nazwa = '$uName', 
    jednostka = '$jednostka',
    id_listy_zakupow = '$id_listy_zakupow',
    dom_id = '$domID'";
    if(mysqli_query($con,$sql_i)){
    $result["status"] = true;
    $result["message"] = "Produkt poprawnie dodany do listy zakupów";
    }else{
    $result["status"] = false;
    $result["message"] = "Błąd dodawania";}
  }    
}else{
    $result["status"] = false;
    $result["message"] = "Błąd dodawania produktu";
    }
}else{
     $result["status"] = false;
     $result["message"] = "Wypełnij wszystkie pola";
 }
 echo json_encode($result);
            exit(0);
}


if (isset($_POST['dodaj_do_listy_zakupow'])) {
  
  
  
  $id_PZ = $_POST['dodaj_do_listy_zakupow'];
  $ilosc = $_POST['ilosc'];

if(!empty($id_PZ) && !empty($ilosc)){

$sql_pobierz_id = "SELECT * FROM dom_zakupy WHERE id = '$id_PZ'";
  $result_p_id = $con->query($sql_pobierz_id);
  if ($result_p_id->num_rows >0) {
     while($row_p_id = mysqli_fetch_array($result_p_id)){
	$id_produktu = $row_p_id['id_produktu'];
	$nazwa_produktu = $row_p_id['nazwa_produktu'];
	$id_sklep = $row_p_id['id_sklep'];
	$sklep = $row_p_id['sklep'];
	$cena_za_sztuke = $row_p_id['cena'];
	$kaucja = $row_p_id['kaucja'];
	$jednostka = $row_p_id['jednostka'];
}
$suma_wartosci_kaucji =  $ilosc * $kaucja;

$cena = $ilosc * $cena_za_sztuke;
    $cena_formatka = number_format($cena, 2);
    $sql_LZ = "INSERT INTO dom_lista_zakupow 
    SET 
    id_produktu = '$id_produktu', 
    nazwa_produktu = '$nazwa_produktu', 
    sklep_id = '$id_sklep', 
    sklep = '$sklep', 
    ilosc = '$ilosc', 
    data = '$data', 
    unique_id = '$uID', 
    nazwa = '$uName', 
    jednostka = '$jednostka', 
    wartosc_kaucji = '$suma_wartosci_kaucji',
    cena_za_sztuke = '$cena_za_sztuke', 
    cena = '$cena_formatka', 
    dom_id = '$domID'";
    if(mysqli_query($con,$sql_LZ)){
        $result["status"] = true;
        $result["message"] = "Prodkt '$nazwa_produktu' poprawnie dodany do listy zakupów!";
    }else {
        $result["status"] = false;
        $result["message"] = "Błąd dodawania produktu '$nazwa_produktu'.";
        }
        
  }else {
        $result["status"] = false;
        $result["message"] = "Nie znaleziono produktu.";
        }
}else{
     $result["status"] = false;
     $result["message"] = "Wypełnij wszystkie pola.";
 }
 echo json_encode($result);
            exit(0);
}

















?>