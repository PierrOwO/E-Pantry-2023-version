<?php
class DBOperations{


	 private $host = 'host';
	 private $user = 'root';
	 private $db = 'db';
	 private $pass = '';
	 private $conn;

public function __construct() {

	$this -> conn = new PDO("mysql:host=".$this -> host.";dbname=".$this -> db, $this -> user, $this -> pass);

}
public function insertDataZaproszenieDoAplikacji($email){
    $data1 = date('d.m.Y');
    session_start();
    $uID = $_SESSION['dom_id_u'];
    $uName = $_SESSION['dom_name'];
    $domID = $_SESSION['dom_id_dom'];
    $domName = $_SESSION['dom_nazwa_dom'];
    
 	$sql = 'INSERT INTO dom_aplikacja_zaproszenia SET id_zapraszajacy =:id_zapraszajacy,
    nazwa_zapraszajacy =:nazwa_zapraszajacy,id_spizarni =:id_spizarni,data =:data, nazwa_spizarni =:nazwa_spizarni, email =:email';

 	$query = $this ->conn ->prepare($sql);
 	$query->execute(array(
 	    ':email' => $email,
 	    ':id_zapraszajacy' => $uID,
        ':nazwa_zapraszajacy' => $uName,
        ':id_spizarni' => $domID,
        ':nazwa_spizarni' => $domName,
        ':data' => $data1));
    if ($query) {
        $user["inviter"] = $uName;
        $user["spizarnia"] = $domName;
        return $user;
    } else {
        return false;
    }
}
public function insertDataZaproszenie2($email,$dom_id,$dom_name){
    $domID = $dom_id;
    $domName =  $dom_name;
    
    $data1 = date('d.m.Y');
    
    $sql1 = 'SELECT * FROM dom_users WHERE email = :email ';
    $query1 = $this -> conn -> prepare($sql1);
    $query1 -> execute(array(':email' => $email));
    $data = $query1 -> fetchObject();
    $unique_id = $data -> unique_id;
    $nazwa = $data -> name;
    
    $sql2 = 'SELECT * FROM dom_aplikacja_zaproszenia WHERE email = :email AND id_spizarni=:id_spizarni';
    $query2 = $this -> conn -> prepare($sql1);
    $query2 -> execute(array(':email' => $email, ':id_spizarni' => $domID));
    $data2 = $query2 -> fetchObject();
    $uID = $data2 -> id_zapraszajacy;
    $uName = $data2 -> nazwa_zapraszajacy;
    
    $status = "1";
    
    
    
 	$sql = 'INSERT INTO dom_moja_spizarnia_zaproszenia SET unique_id =:unique_id,id_zapraszajacy =:id_zapraszajacy,
    nazwa_zapraszajacy =:nazwa_zapraszajacy,id_spizarni =:id_spizarni,data =:data, nazwa_spizarni =:nazwa_spizarni';

 	$query = $this ->conn ->prepare($sql);
 	$query->execute(array(
 	    ':unique_id' => $unique_id,
 	    ':id_zapraszajacy' => $uID,
        ':nazwa_zapraszajacy' => $uName,
        ':id_spizarni' => $domID,
        ':nazwa_spizarni' => $domName,
        ':data' => $data1));
    if ($query) {
        $sql = 'UPDATE dom_aplikacja_zaproszenia SET status =:status WHERE email =:email';
    
        $query11 = $this ->conn ->prepare($sql11);
 	$query11->execute(array(':email' => $email,':status' => $status));
 	
 	
        $user["name"] = $nazwa;
        $user["inviter"] = $uName;
        $user["spizarnia"] = $domName;
        return $user;
    } else {
        return false;
    }
}
public function insertDataZaproszenie($email){
    
    
    $data1 = date('d.m.Y');
    
    $sql1 = 'SELECT * FROM dom_users WHERE email = :email';
    $query1 = $this -> conn -> prepare($sql1);
    $query1 -> execute(array(':email' => $email));
    $data = $query1 -> fetchObject();
    $unique_id = $data -> unique_id;
    $nazwa = $data -> name;
    
    session_start();
    $uID = $_SESSION['dom_id_u'];
    $uName = $_SESSION['dom_name'];
    $domID = $_SESSION['dom_id_dom'];
    $domName = $_SESSION['dom_nazwa_dom'];
    
 	$sql = 'INSERT INTO dom_moja_spizarnia_zaproszenia SET unique_id =:unique_id,id_zapraszajacy =:id_zapraszajacy,
    nazwa_zapraszajacy =:nazwa_zapraszajacy,id_spizarni =:id_spizarni,data =:data, nazwa_spizarni =:nazwa_spizarni';

 	$query = $this ->conn ->prepare($sql);
 	$query->execute(array(
 	    ':unique_id' => $unique_id,
 	    ':id_zapraszajacy' => $uID,
        ':nazwa_zapraszajacy' => $uName,
        ':id_spizarni' => $domID,
        ':nazwa_spizarni' => $domName,
        ':data' => $data1));
    if ($query) {
        $user["name"] = $nazwa;
        $user["inviter"] = $uName;
        $user["spizarnia"] = $domName;
        return $user;
        //return true;
    } else {
        return false;
    }
}

public function insertData($name,$email,$password){
    $time = date("Y.m.d, H:i:s");
 	$unique_id = uniqid('', true);
    $hash = $this->getHash($password);
    $encrypted_password = $hash["encrypted"];
	$salt = $hash["salt"];

 	$sql = 'INSERT INTO dom_users SET unique_id =:unique_id,name =:name,
    email =:email,encrypted_password =:encrypted_password,salt =:salt,created_at = :date';

 	$query = $this ->conn ->prepare($sql);
 	$query->execute(array(
 	    'unique_id' => $unique_id,
 	    ':name' => $name,
 	    ':email' => $email,
 	    ':encrypted_password' => $encrypted_password,
 	    ':salt' => $salt,
 	    ':date' => $time));
    if ($query) {
        return true;
    } else {
        return false;
    }
}

public function czyUserJestCzlonkiem($email){

    $sql1 = 'SELECT * from dom_users WHERE email =:email';
    $query1 = $this -> conn -> prepare($sql1);
    $query1 -> execute(array('email' => $email));
    $data = $query1 -> fetchObject();
    $unique_id = $data -> unique_id;
    
    session_start();
    $id_spizarni = $_SESSION['dom_id_dom'];
    
    $sql = 'SELECT COUNT(*) from dom_moja_spizarnia_users WHERE unique_id =:unique_id AND id_spizarni =:id_spizarni';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':unique_id' => $unique_id, ':id_spizarni' => $id_spizarni));
    if($query){

        $row_count = $query -> fetchColumn();

        if ($row_count == 0){

            return false;

        } else {

            return true;

        }
    } else {

        return false;
    }
 }
public function checkUserExist($email){

    $sql = 'SELECT COUNT(*) from dom_users WHERE email =:email';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array('email' => $email));

    if($query){

        $row_count = $query -> fetchColumn();

        if ($row_count == 0){

            return false;

        } else {

            return true;

        }
    } else {

        return false;
    }
 } 

public function checkLogin($email, $password) {

    $sql = 'SELECT * FROM dom_users WHERE email = :email';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':email' => $email));
    $data = $query -> fetchObject();
    $salt = $data -> salt;
    $db_encrypted_password = $data -> encrypted_password;

    if ($this -> verifyHash($password.$salt,$db_encrypted_password) ) {
        $aktywacja = $data -> aktywacja;
        if($aktywacja == "1"){
            $cookie_name = "user";
            $userID = $data -> unique_id;
            setcookie($cookie_name, $userID, time() + (86400 * 30), "/"); 

        session_start();
        $_SESSION['dom_id_u'] = $data -> unique_id;
        $_SESSION['dom_name'] = $data -> name;
        $_SESSION['dom_status'] = $data -> status;
        }
        $user["name"] = $data -> name;
        $user["email"] = $data -> email;
        $user["unique_id"] = $data -> unique_id;
	    $user["created_at"] = $data -> created_at;
	    $user["aktywacja"] = $data -> aktywacja;
        return $user;

    } else {

        return false;
    }

 }
 public function checkUserIsActivated($email){
	 
    $aktywacja = "1";
	
    $sql = 'SELECT COUNT(*) from dom_users WHERE email =:email AND aktywacja =:aktywacja';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array('email' => $email, 'aktywacja' => $aktywacja));

    if($query){

        $row_count = $query -> fetchColumn();

        if ($row_count == 0){

            return false;

        } else {

            return true;

        }
    } else {

        return false;
    }
 }



public function registerInvitionRequest($email,$name){
    $random_string = substr(str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz", 20)), 0, 20);
    $hash = $this->getHash($random_string);
    $encrypted_temp_password = $hash["encrypted"];
    $salt = $hash["salt"];
     session_start();
    $domID = $_SESSION['dom_id_dom'];
    $domName = $_SESSION['dom_nazwa_dom'];

            $insert_sql = 'INSERT INTO dom_invition SET email =:email,encrypted_temp_password =:encrypted_temp_password,
                    salt =:salt,created_at = :created_at, dom_id =:dom_id, dom_name =:dom_name';
            $insert_query = $this ->conn ->prepare($insert_sql);
            $insert_query->execute(array(':email' => $email, ':encrypted_temp_password' => $encrypted_temp_password, 
            ':salt' => $salt, ':created_at' => date("Y-m-d H:i:s"), ':dom_id' => $domID, ':dom_name' => $domName));

            if ($insert_query) {

                $user["email"] = $email;
                $user["pass"] = $encrypted_temp_password;
                $user["salt"] = $salt;
                $user["name"] = $name;

                return $user;

            } else {

                return false;

            }

 }
public function registerInvitionRequest2($email,$name,$dom_id,$dom_name){
    $random_string = substr(str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz", 20)), 0, 20);
    $hash = $this->getHash($random_string);
    $encrypted_temp_password = $hash["encrypted"];
    $salt = $hash["salt"];

    $domID = $dom_id;
    $domName = $dom_name;

            $insert_sql = 'INSERT INTO dom_invition SET email =:email,encrypted_temp_password =:encrypted_temp_password,
                    salt =:salt,created_at = :created_at, dom_id =:dom_id, dom_name =:dom_name';
            $insert_query = $this ->conn ->prepare($insert_sql);
            $insert_query->execute(array(':email' => $email, ':encrypted_temp_password' => $encrypted_temp_password, 
            ':salt' => $salt, ':created_at' => date("Y-m-d H:i:s"), ':dom_id' => $domID, ':dom_name' => $domName));

            if ($insert_query) {

                //$user["email"] = $email;
                $user["pass"] = $encrypted_temp_password;
                $user["salt"] = $salt;
                //$user["name"] = $name;

                return $user;

            } else {

                return false;

            }

 }
public function registerInvitionRequest3($email){
    $random_string = substr(str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz", 20)), 0, 20);
    $hash = $this->getHash($random_string);
    $encrypted_temp_password = $hash["encrypted"];
    $salt = $hash["salt"];
     session_start();
    $domID = $_SESSION['dom_id_dom'];
    $domName = $_SESSION['dom_nazwa_dom'];

            $insert_sql = 'INSERT INTO dom_app_invition SET email =:email,encrypted_temp_password =:encrypted_temp_password,
                    salt =:salt,created_at = :created_at, dom_id =:dom_id, dom_name =:dom_name';
            $insert_query = $this ->conn ->prepare($insert_sql);
            $insert_query->execute(array(':email' => $email, ':encrypted_temp_password' => $encrypted_temp_password, 
            ':salt' => $salt, ':created_at' => date("Y-m-d H:i:s"), ':dom_id' => $domID, ':dom_name' => $domName));

            if ($insert_query) {

                $user["email"] = $email;
                $user["pass"] = $encrypted_temp_password;
                $user["salt"] = $salt;

                return $user;

            } else {

                return false;

            }

 }


public function registerActivationRequest($email,$name){

    $random_string = substr(str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz", 6)), 0, 6);
    $hash = $this->getHash($random_string);
    $encrypted_temp_password = $hash["encrypted"];
    $salt = $hash["salt"];

    $sql = 'SELECT COUNT(*) from dom_acc_activation WHERE email =:email';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array('email' => $email));

    if($query){

        $row_count = $query -> fetchColumn();

        if ($row_count == 0){


            $insert_sql = 'INSERT INTO dom_acc_activation SET email =:email,encrypted_temp_password =:encrypted_temp_password,
                    salt =:salt,created_at = :created_at';
            $insert_query = $this ->conn ->prepare($insert_sql);
            $insert_query->execute(array(':email' => $email, ':encrypted_temp_password' => $encrypted_temp_password, 
            ':salt' => $salt, ':created_at' => date("Y-m-d H:i:s")));

            if ($insert_query) {

                $user["email"] = $email;
                $user["temp_password"] = $random_string;
                $user["name"] = $name;

                return $user;

            } else {

                return false;

            }


        } else {

            $update_sql = 'UPDATE dom_acc_activation SET email =:email,encrypted_temp_password =:encrypted_temp_password,
                    salt =:salt,created_at = :created_at';
            $update_query = $this -> conn -> prepare($update_sql);
            $update_query -> execute(array(':email' => $email, ':encrypted_temp_password' => $encrypted_temp_password, 
            ':salt' => $salt, ':created_at' => date("Y-m-d H:i:s")));

            if ($update_query) {
        
                $user["email"] = $email;
                $user["temp_password"] = $random_string;
                return $user;

            } else {

                return false;

            }

        }
    } else {

        return false;
    }


 }
public function AktywacjaKonta($email,$aktywacja){


    $sql = 'SELECT * FROM dom_acc_activation WHERE email = :email';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':email' => $email));
    $data = $query -> fetchObject();
    $salt = $data -> salt;
    $db_encrypted_temp_password = $data -> encrypted_temp_password;

    if ($this -> verifyHash($aktywacja.$salt,$db_encrypted_temp_password) ) {

      return $this -> aktywacjaKontac($email);

    } else {

        return false;
    }

 }
public function aktywacjaKontac($email){


   

    $sql = 'UPDATE dom_users SET aktywacja = "1" WHERE email = :email';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':email' => $email));

    if ($query) {
        
        return true;

    } else {

        return false;

    }

 }

 
 
 
 public function passwordResetRequest($email){

    $random_string = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 6)), 0, 6);
    $hash = $this->getHash($random_string);
    $encrypted_temp_password = $hash["encrypted"];
    $salt = $hash["salt"];

    $sql = 'SELECT COUNT(*) from password_reset_request WHERE email =:email';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array('email' => $email));

    if($query){

        $row_count = $query -> fetchColumn();

        if ($row_count == 0){


            $insert_sql = 'INSERT INTO password_reset_request SET email =:email,encrypted_temp_password =:encrypted_temp_password,
                    salt =:salt,created_at = :created_at';
            $insert_query = $this ->conn ->prepare($insert_sql);
            $insert_query->execute(array(':email' => $email, ':encrypted_temp_password' => $encrypted_temp_password, 
            ':salt' => $salt, ':created_at' => date("Y-m-d H:i:s")));

            if ($insert_query) {

                $user["email"] = $email;
                $user["temp_password"] = $random_string;

                return $user;

            } else {

                return false;

            }


        } else {

            $update_sql = 'UPDATE password_reset_request SET email =:email,encrypted_temp_password =:encrypted_temp_password,
                    salt =:salt,created_at = :created_at';
            $update_query = $this -> conn -> prepare($update_sql);
            $update_query -> execute(array(':email' => $email, ':encrypted_temp_password' => $encrypted_temp_password, 
            ':salt' => $salt, ':created_at' => date("Y-m-d H:i:s")));

            if ($update_query) {
        
                $user["email"] = $email;
                $user["temp_password"] = $random_string;
                return $user;

            } else {

                return false;

            }

        }
    } else {

        return false;
    }


 }
 public function resetPassword($email,$code,$password){


    $sql = 'SELECT * FROM password_reset_request WHERE email = :email';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':email' => $email));
    $data = $query -> fetchObject();
    $salt = $data -> salt;
    $db_encrypted_temp_password = $data -> encrypted_temp_password;

    if ($this -> verifyHash($code.$salt,$db_encrypted_temp_password) ) {

        $old = new DateTime($data -> created_at);
        $now = new DateTime(date("Y-m-d H:i:s"));
        $diff = $now->getTimestamp() - $old->getTimestamp();
        
        if($diff < 300) {

            return $this -> changePassword($email, $password);

        } else {

            false;
        }
        

    } else {

        return false;
    }

 }
 public function changePassword($email, $password){


    $hash = $this -> getHash($password);
    $encrypted_password = $hash["encrypted"];
    $salt = $hash["salt"];

    $sql = 'UPDATE dom_users SET encrypted_password = :encrypted_password, salt = :salt WHERE email = :email';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':email' => $email, ':encrypted_password' => $encrypted_password, ':salt' => $salt));

    if ($query) {
        
        return true;

    } else {

        return false;

    }

 }
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 public function getHash($password) {

     $salt = sha1(rand());
     $salt = substr($salt, 0, 10);
     $encrypted = password_hash($password.$salt, PASSWORD_DEFAULT);
     $hash = array("salt" => $salt, "encrypted" => $encrypted);

     return $hash;

}



public function verifyHash($password, $hash) {

    return password_verify ($password, $hash);
}
}
?>