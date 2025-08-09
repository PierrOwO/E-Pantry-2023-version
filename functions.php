<?php
require_once 'db.php';
require 'PHPMailer/PHPMailerAutoload.php';

class Functions{

private $db;
private $mail;

public function __construct() {

      $this -> db = new DBOperations();
      $this -> mail = new PHPMailer;

}
public function zaprosDoAplikacji($email) {
	$db = $this -> db;
	if (!empty($email)) {
  			$result = $db -> insertDataZaproszenieDoAplikacji($email);
  			if ($result) {
			    $result2 =  $db -> registerInvitionRequest3($email); 
			    if(!$result2){
				    $response["result"] = "failure";
				    $response["message"] = "Błąd";
				    return json_encode($response);
			    }else {
				    $mail_result = $this -> sendEmailInvition3(
				                                                $result2["email"],
				                                                $result2["pass"],
				                                                $result2["salt"]);
				    if($mail_result){
				        $response["result"] = "success";
				        $response["message"] = "Zaproszenie wysłane pomyślnie!";
				        return json_encode($response);
			        }else {
				        $response["result"] = "failure";
				        $response["message"] = "Błąd";
        				return json_encode($response);
				    }
			    }						
  			}else {
  				$response["result"] = "failure";
  				$response["message"] = "Rejestracja nieudana";
  				return json_encode($response);
  			}
  	}else {
  		return $this -> getMsgParamNotEmpty();
  	}
}
public function zaprosDoSpizarni($email) {
	$db = $this -> db;
	if (!empty($email)) {
		if ($db -> checkUserExist($email)) {
  		  if ($db -> czyUserJestCzlonkiem($email)) {
  		        $response["result"] = "failure";
                $response["message"] = "Użytkownik jest już członkiem spiżarni";
                return json_encode($response);
  		  }else{
  			$result = $db -> insertDataZaproszenie($email);
  			if ($result) {
			    $result2 =  $db -> registerInvitionRequest($email,$result["name"]); 
			    if(!$result2){
				    $response["result"] = "failure";
				    $response["message"] = "Błąd";
				    return json_encode($response);
			    }else {
				    $mail_result = $this -> sendEmailInvition(
				                                                $result2["email"],
				                                                $result2["pass"],
				                                                $result2["salt"],
				                                                $result2["name"]);
				    if($mail_result){
				        $response["result"] = "success";
				        $response["message"] = "Zaproszenie wysłane pomyślnie!";
				        return json_encode($response);
			        }else {
				        $response["result"] = "failure";
				        $response["message"] = "Błąd";
        				return json_encode($response);
				    }
			    }						
  			}else {
  				$response["result"] = "failure";
  				$response["message"] = "Rejestracja nieudana";
  				return json_encode($response);
  			}
  		
  		  }
		    
		}else {
  		    $response["result"] = "notexist";
  			$response["message"] = "Nie znaleziono uzytkownika";
  			return json_encode($response);
  		}		
  	}else {
  		return $this -> getMsgParamNotEmpty();
  	}
}
public function zaprosDoSpizarni2($email,$dom_id,$dom_name) {
	$db = $this -> db;
	if (!empty($email)) {
		if ($db -> checkUserExist($email)) {
  			$result = $db -> insertDataZaproszenie2($email,$dom_id,$dom_name);
  			if ($result) {
  			    $name = $result["name"];
  			    $inviter = $result["inviter"];

			    $result2 =  $db -> registerInvitionRequest2($email,$name,$dom_id,$dom_name); 
			    if(!$result2){
				    $response["result"] = "failure";
				    $response["message"] = "Błąd";
				    return json_encode($response);
			    }else {
			        $salt = $result2["salt"];
			        $pass = $result2["pass"];
				    $mail_result = $this -> sendEmailInvition2($email,$pass,$salt,$name,$inviter,$dom_name);
				    if($mail_result){
				        $response["result"] = "success";
				        $response["message"] = "Zaproszenie wysłane pomyślnie!";
				        return json_encode($response);
			        }else {
				        $response["result"] = "failure";
				        $response["message"] = "Błąd";
        				return json_encode($response);
				    }
			    }						
  			}else {
  				$response["result"] = "failure";
  				$response["message"] = "Rejestracja nieudana";
  				return json_encode($response);
  			}
  		
		}else {
  		    $response["result"] = "notexist";
  			$response["message"] = "Nie znaleziono uzytkownika";
  			return json_encode($response);
  		}		
  	}else {
  		return $this -> getMsgParamNotEmpty();
  	}
}

////////////////////////////////////////////////////////////////////////////////
public function registerUser($name, $email, $password) {
	$db = $this -> db;
	if (!empty($name) && !empty($email) && !empty($password)) {
		if ($db -> checkUserExist($email)) {
  			$response["result"] = "failure";
  			$response["message"] = "Użytkownik już istnieje !";
  			return json_encode($response);
  		}else {
  			$result = $db -> insertData($name, $email, $password);
  			if ($result) {
			    $result2 =  $db -> registerActivationRequest($email, $name); 
			    if(!$result2){
				    $response["result"] = "failure";
				    $response["message"] = "Błąd";
				    return json_encode($response);
			    }else {
				    $mail_result = $this -> sendEmailActivation($result2["email"],$result2["temp_password"],$result2["name"]);
				    if($mail_result){
				        $response["result"] = "success";
				        $response["message"] = "Konto utworzone pomyślnie !";
				        return json_encode($response);
			        }else {
				        $response["result"] = "failure";
				        $response["message"] = "Błąd";
        				return json_encode($response);
				    }
			    }						
  			}else {
  				$response["result"] = "failure";
  				$response["message"] = "Rejestracja nieudana";
  				return json_encode($response);
  			}
  		}					
  	}else {
  		return $this -> getMsgParamNotEmpty();
  	}
}
////////////////////////////////////////////////////////////////////////////////
public function loginUser($email, $password) {

  $db = $this -> db;

  if (!empty($email) && !empty($password)) {

    if ($db -> checkUserExist($email)) {
		
		$result =  $db -> checkLogin($email, $password);

       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Błędne dane logowania";
        return json_encode($response);

       } else {

	    $result2 =  $db -> checkUserIsActivated($email);
        if(!$result2) {

        $response["result"] = "notactivated";
	    $response["user"] = $result;
	    $response["message"] = "konto nie zostało aktywowane";
        return json_encode($response);

       } else {

        $response["result"] = "success";
        $response["message"] = "Zalogowano pomyślnie, przekierowywanie..";
        $response["user"] = $result;
        return json_encode($response);
		}
		}
    } else {

      $response["result"] = "failure";
      $response["message"] = "Nie znaleziono konta o podanym adresie Email";
      return json_encode($response);

    }
  } else {

      return $this -> getMsgParamNotEmpty();
    }

}

public function aktywacjaKonta($email, $aktywacja) {

  $db = $this -> db;
  
   if ($db -> checkUserExist($email)) {
   
    $result = $db -> AktywacjaKonta($email, $aktywacja);

      if(!$result){
	  
		$response["result"] = "failure";
        $response["message"] = 'Błędny Kod';
        return json_encode($response);
		
      } else {

        $response["result"] = "success";
        $response["message"] = "Konto Aktywowane";
        return json_encode($response);
      }
	  
	} else {

    $response["result"] = "failure";
    $response["message"] = "Użytkownik nie istnieje";
    return json_encode($response);

  }

}


public function sendEmailInvition($email,$pass,$salt,$name){
    session_start();
    $inviter = $_SESSION['dom_name'];
    $spizarnia = $_SESSION['dom_nazwa_dom'];
    
  $mail = $this -> mail;
  $mail->isSMTP();
  $mail->Host = '';
  $mail->SMTPAuth = true;
  $mail->Username = '';
  $mail->Password = '';
  $mail->SMTPSecure = 'ssl';
  $mail->Port = 465;
 
  $mail->From = "";
  $mail->FromName = 'Spizarnia';
  $mail->addAddress($email, $name);
 
  $mail->addReplyTo('', 'noreply');
 
  $mail->WordWrap = 50;
  $mail->isHTML(true);
 
  $mail->Subject = 'Zaproszenie do Spiżarni';
  $mail->Body    = 'Witaj '.$name.',<br><br> 
  <b>'.$inviter.'</b> prosi Cię o dołączenie do spiżarni <b>'.$spizarnia.'</b>. <br>
  Kliknij poniższy link aby dołączyć, albo zaakceptuj po zalogowaniu.
  <br><br>
  dom.pieterapps.pl/zaproszenia/?p='.$pass.'&&s='.$salt.'&&i=true 
  <br><br>
  Aby odrzucić to zaproszenie kliknij w link poniżej.
  <br><br>
  dom.pieterapps.pl/zaproszenia/?p='.$pass.'&&s='.$salt.'&&i=false 
  <br><br>
  
  Nie odpowiadaj na ten email. Wiadomość generowana automatycznie.';

  if(!$mail->send()) {

   return $mail->ErrorInfo;

  } else {

    return true;

  }

}
public function sendEmailInvition2($email,$pass,$salt,$name,$inviter,$dom_name){
    
  $mail = $this -> mail;
  $mail->isSMTP();
  $mail->Host = '';
  $mail->SMTPAuth = true;
  $mail->Username = '';
  $mail->Password = '';
  $mail->SMTPSecure = 'ssl';
  $mail->Port = 465;
 
  $mail->From = "";
  $mail->FromName = 'Spizarnia';
  $mail->addAddress($email, $name);
 
  $mail->addReplyTo('', 'noreply');
 
  $mail->WordWrap = 50;
  $mail->isHTML(true);
 
  $mail->Subject = 'Zaproszenie do Spiżarni';
  $mail->Body    = 'Witaj '.$name.',<br><br> 
  <b>'.$inviter.'</b> prosi Cię o dołączenie do spiżarni <b>'.$dom_name.'</b>. <br>
  Kliknij poniższy link aby dołączyć, albo zaakceptuj po zalogowaniu.
  <br><br>
  dom.pieterapps.pl/zaproszenia/?p='.$pass.'&&s='.$salt.'&&i=true 
  <br><br>
  Aby odrzucić to zaproszenie kliknij w link poniżej.
  <br><br>
  dom.pieterapps.pl/zaproszenia/?p='.$pass.'&&s='.$salt.'&&i=false 
  <br><br>
  
  Nie odpowiadaj na ten email. Wiadomość generowana automatycznie.';

  if(!$mail->send()) {

   return $mail->ErrorInfo;

  } else {

    return true;

  }

}
public function sendEmailInvition3($email,$pass,$salt){
    session_start();
    $inviter = $_SESSION['dom_name'];
    $spizarnia = $_SESSION['dom_nazwa_dom'];
    
  $mail = $this -> mail;
  $mail->isSMTP();
  $mail->Host = '';
  $mail->SMTPAuth = true;
  $mail->Username = '';
  $mail->Password = '';
  $mail->SMTPSecure = 'ssl';
  $mail->Port = 465;
 
  $mail->From = "";
  $mail->FromName = 'Spizarnia';
  $mail->addAddress($email, $name);
 
  $mail->addReplyTo('', 'noreply');
 
  $mail->WordWrap = 50;
  $mail->isHTML(true);
 
  $mail->Subject = 'Spizarnia - zaproszenie';
  $mail->Body    = 'Witaj,<br><br> 
  <b>'.$inviter.'</b> używa aplikacji <b>Spiżarnia</b> i prosi Cię o dołączenie do niej jak i o dołączenie do jego spiżarni: <b>'.$spizarnia.'</b>. <br>
  Kliknij poniższy link aby dokończyć zakładanie darmowego konta.
  <br><br>
  dom.pieterapps.pl/zaproszenia/?p='.$pass.'&&s='.$salt.'&&op=app
  <br><br>
 
  <br><br>
  
  Nie odpowiadaj na ten email. Wiadomość generowana automatycznie.';

  if(!$mail->send()) {

   return $mail->ErrorInfo;

  } else {

    return true;

  }

}

public function resetPasswordRequest($email){

  $db = $this -> db;

  if ($db -> checkUserExist($email)) {

    $result =  $db -> passwordResetRequest($email);

    if(!$result){

      $response["result"] = "failure";
      $response["message"] = "Błąd resetu hasła";
      return json_encode($response);

    } else {

      $mail_result = $this -> sendEmail($result["email"],$result["temp_password"]);

      if($mail_result){

        $response["result"] = "success";
        $response["message"] = "Na podany Email wysłany został kod potrzebny do resetu hasła.";
        return json_encode($response);

      } else {

        $response["result"] = "failure";
        $response["message"] = "Błąd resetu hasła";
        return json_encode($response);
      }
    }


  } else {

    $response["result"] = "failure";
    $response["message"] = "Nie znaleziono podanego Emaila";
    return json_encode($response);

  }

}

public function resetPassword($email,$code,$password){

  $db = $this -> db;

  if ($db -> checkUserExist($email)) {

    $result =  $db -> resetPassword($email,$code,$password);

    if(!$result){

      $response["result"] = "failure";
      $response["message"] = "Błąd resetu hasła";
      return json_encode($response);

    } else {

      $response["result"] = "success";
      $response["message"] = "Hasło zmieniono pomyślnie";
      return json_encode($response);

    }


  } else {

    $response["result"] = "failure";
    $response["message"] = "Nie znaleziono podanego Emaila";
    return json_encode($response);

  }

}

public function sendEmail($email,$temp_password){

  $mail = $this -> mail;
  $mail->isSMTP();
  $mail->Host = '';
  $mail->SMTPAuth = true;
  $mail->Username = '';
  $mail->Password = '';
  $mail->SMTPSecure = 'ssl';
  $mail->Port = 465;
 
  $mail->From = "";
  $mail->FromName = 'Spizarnia';
  $mail->addAddress($email, $name);
 
  $mail->addReplyTo('', 'noreply');
 
  $mail->WordWrap = 50;
  $mail->isHTML(true);
 
  $mail->Subject = 'Reset Hasla';
  $mail->Body    = '<br><br> Kod potrzebny do resetu hasła to  <b>'.$temp_password.'</b> . Kod jest ważny przez 300s (5 minut). Wpisz go wciągu tego czasu aby dokonac zmiany hasła.<br><br><br>Nie odpowiadaj na ten email. Wiadomość generowana automatycznie.';

  if(!$mail->send()) {

   return $mail->ErrorInfo;

  } else {

    return true;

  }

}

public function sendEmailActivation($email,$temp_password,$name){

  $mail = $this -> mail;
  $mail->isSMTP();
  $mail->Host = '';
  $mail->SMTPAuth = true;
  $mail->Username = '';
  $mail->Password = '';
  $mail->SMTPSecure = 'ssl';
  $mail->Port = 465;
 
  $mail->From = "";
  $mail->FromName = 'Spizarnia';
  $mail->addAddress($email, $name);
 
  $mail->addReplyTo('', 'noreply');
 
  $mail->WordWrap = 50;
  $mail->isHTML(true);
 
  $mail->Subject = 'Aktywacja Konta';
  $mail->Body    = 'Witaj '.$name.',<br><br> Kod potrzebny do aktywacji konta to <b>'.$temp_password.'</b> . Uzyj go aby moc korzystac z aplikacji <br><br>Nie odpowiadaj na ten email. Wiadomość generowana automatycznie.';

  if(!$mail->send()) {

   return $mail->ErrorInfo;

  } else {

    return true;

  }

}

public function sendPHPMailActivation($email,$temp_password){

  $subject = 'Aktywacja Konta';
  $message = ' Kod potrzebny do aktywacji konta to '.$temp_password.'. Uzyj go aby moc korzystac z aplikacji';
  $from = "noreply@dom.pieterapps.pl";
  $headers = "From:" . $from;

  return mail($email,$subject,$message,$headers);

}

public function isEmailValid($email){

  return filter_var($email, FILTER_VALIDATE_EMAIL);
}

public function getMsgParamNotEmpty(){


  $response["result"] = "failure";
  $response["message"] = "Wypełnij wszystkie pola!";
  return json_encode($response);

}

public function getMsgInvalidParam(){

  $response["result"] = "failure";
  $response["message"] = "Błędne dane";
  return json_encode($response);

}

public function getMsgInvalidEmail(){

  $response["result"] = "failure";
  $response["message"] = "Błędny Email";
  return json_encode($response);

}
}
?>