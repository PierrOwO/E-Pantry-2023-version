<?php

require_once 'functions.php';

$fun = new Functions();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  $data = json_decode(file_get_contents("php://input"));

  if(isset($data -> operation)){

  	$operation = $data -> operation;

  	if(!empty($operation)){
  	    
  	    if($operation == 'inviteToApp'){  

  			if(isset($data -> user ) && !empty($data -> user) && isset($data -> user -> email)){
  			    
                $user = $data -> user;
                $email = $user -> email;


          if ($fun -> isEmailValid($email)) {
            
            echo $fun -> zaprosDoAplikacji($email);

          } else {

            echo $fun -> getMsgInvalidEmail();
          }

  			} else {

  				echo $fun -> getMsgInvalidParam();

  			}

  		}else if($operation == 'invite2'){  

  			if(isset($data -> user ) && !empty($data -> user) && isset($data -> user -> email) && isset($data -> user -> dom_id) && isset($data -> user -> dom_name)){
  			    
                $user = $data -> user;
                $email = $user -> email;
                $dom_id = $user -> dom_id;
                $dom_name = $user -> dom_name;


          if ($fun -> isEmailValid($email)) {
            
            echo $fun -> zaprosDoSpizarni2($email,$dom_id,$dom_name);

          } else {

            echo $fun -> getMsgInvalidEmail();
          }

  			} else {

  				echo $fun -> getMsgInvalidParam();

  			}

  		}else if($operation == 'invite'){  

  			if(isset($data -> user ) && !empty($data -> user) && isset($data -> user -> email)){
  			    
                $user = $data -> user;
                $email = $user -> email;


          if ($fun -> isEmailValid($email)) {
            
            echo $fun -> zaprosDoSpizarni($email);

          } else {

            echo $fun -> getMsgInvalidEmail();
          }

  			} else {

  				echo $fun -> getMsgInvalidParam();

  			}

  		}else if($operation == 'register'){  

  			if(isset($data -> user ) && !empty($data -> user) && isset($data -> user -> name) 
  				&& isset($data -> user -> email) && isset($data -> user -> password)){

  				$user = $data -> user;
  				$name = $user -> name;
  				$email = $user -> email;
  				$password = $user -> password;

          if ($fun -> isEmailValid($email)) {
            
            echo $fun -> registerUser($name, $email, $password);

          } else {

            echo $fun -> getMsgInvalidEmail();
          }

  			} else {

  				echo $fun -> getMsgInvalidParam();

  			}

  		}else if ($operation == 'login') {

        if(isset($data -> user ) && !empty($data -> user) && isset($data -> user -> email) && isset($data -> user -> password)){

          $user = $data -> user;
          $email = $user -> email;
          $password = $user -> password;

          echo $fun -> loginUser($email, $password);

        } else {

          echo $fun -> getMsgInvalidParam();

        }
      }else if ($operation == 'activation') {

        if(isset($data -> user ) && !empty($data -> user) && isset($data -> user -> email) && isset($data -> user -> aktywacja)){

          $user = $data -> user;
          $email = $user -> email;
          $aktywacja = $user -> aktywacja;

          echo $fun -> aktywacjaKonta($email,$aktywacja);

        } else {

          echo $fun -> getMsgInvalidParam();

        }
      }else if ($operation == 'resPassReq') {

        if(isset($data -> user) && !empty($data -> user) &&isset($data -> user -> email)){

          $user = $data -> user;
          $email = $user -> email;

          echo $fun -> resetPasswordRequest($email);

        } else {

          echo $fun -> getMsgInvalidParam();

        }
      }else if ($operation == 'resPass') {

        if(isset($data -> user) && !empty($data -> user) && isset($data -> user -> email) && isset($data -> user -> password) 
          && isset($data -> user -> code)){

          $user = $data -> user;
          $email = $user -> email;
          $code = $user -> code;
          $password = $user -> password;
          
          echo $fun -> resetPassword($email,$code,$password);

        } else {

          echo $fun -> getMsgInvalidParam();

        }
      }
  	    
  	    
  	    
  	}else{
  		echo $fun -> getMsgParamNotEmpty();
  	}
  } else {
  		echo $fun -> getMsgInvalidParam();
  }
}
























