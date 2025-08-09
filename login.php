<?php 
header('Content-type: text/html; charset=utf-8');
include('classy.php');
  if (isset($_SESSION['dom_id_u'])) {
  	header('location: index.php'); 
  }else{
    if(isset($_COOKIE['user'])) {
    $userID = $_COOKIE['user'];
    $result = mysqli_query($conn, "SELECT * FROM dom_users WHERE unique_id = '$userID'");
        if ($result->num_rows >0) {
           while($row = mysqli_fetch_array($result)){
               $uName = $row['name'];
               $userStatus = $row['status'];
               session_start();
               $_SESSION['dom_id_u'] = $userID;
               $_SESSION['dom_name'] = $uName;
               $_SESSION['dom_status'] = $userStatus;
           }
           header('location: index.php'); 
        }
    }

  }
  
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"> </meta>
  <title>Logowanie</title>
    <link rel="stylesheet" href="nav/style.css">
    <link rel="stylesheet" href="style/login.css">
    <link rel="stylesheet" href="style/modal2.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>
<body>
<div class="body_form">
<div class="center" id="body_content">
<div class="content_items" id="content_items">
    <div style="width: 100%; height: auto; margin: 10px;">
    <div style="text-align: center;"><img class="login_user_round" src="img/login_user.png"></div>
 	<div class="input-group2">
  		    <input type="text"  id="name" name="name" placeholder="Nazwa użytkownika" />
	</div>
    <div class="input-group2">
  		    <input type="email"  id="email" name="email" placeholder="Email" />
	</div>
 	<div class="input-group2">
 		<input type="password" id="password" name="password" placeholder="Hasło" />
 	</div>
 	
 	<div class="input-group2" style="text-align: center;">
 		<button type="button" class="button button5" id="b_register" onclick="rejestracja(this.id)">
        <span class="button__text">Rejestracja</span>
        </button>
 	</div>
	<div class="input-group2" style="text-align: center;">
 		<button type="button" class="button button5" id="b_login" onclick="logowanie(this.id)">
        <span class="button__text">Logowanie</span>
        </button>
 	</div>
 	<div class="input-group2" style="width: 80%; margin: 0 auto; display: flex; justify-content: flex-end;">
    <span id="reset_password_txt" class="reset_password_txt" style="margin-right: auto">Reset hasła</span>
    <span id="login_register_txt" class="login_register_txt" style="margin-left: auto">Rejestracja</span>
    </div>
    
    <div class="input-group2" style="text-align: center;">
        <span id="message_txt" class="message_txt"></span>
 	</div>
 	</div>
</div>
</div>
</div>

            <div id="myModalSmall" class="modal_small">
                <div id="center_small" class="center_small">
                    <div id= "content_small" class="modal_small-content_auto">
                        <div class="modal_small-header" id="m_header_small">
                            <h2 style="margin: 0; padding: 10px"><b id="m_title_small"></b></h2>
                            <div class="btn-group">
                            <button class="close " id="close_small">&times;</button>
                            </div>
                        </div>
                        <div class="modal_small-body" id="m_body_small">
                        </div>
                        <div class="modal_small-footer" id="m_footer_small">
                            <div class="btn-group">
                                <button class="btn btn-green spinner-button" id="b_zatwierdz_small" style="display: none; position: relative">
                                        <div class="button-content">
                                            <span class="button__text">Zatwierdź</span>
                                            <span class="spinner-container">
                                            <span class="spinner"></span>
                                            </span>
                                        </div>
                                </button>
                                <button class="btn btn-close" id="b_close_small">Zamknij</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<script src="js/script.js"></script>

</body>
</html>   

