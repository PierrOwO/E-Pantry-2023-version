<?php 
header('Content-type: text/html; charset=utf-8');
include('../classy.php');
$body_accept = "0";
$body_register = "0";
if(isset($_GET['p']) && isset($_GET['s']) && isset($_GET['i']) && !empty($_GET['p']) && !empty($_GET['s']) && !empty($_GET['i'])){
    $hash_pass = $_GET['p'];
    $salt = $_GET['s'];
    $i = $_GET['i'];
    $body_accept = "1";
    $result = mysqli_query($conn, "SELECT * FROM dom_invition WHERE salt = '$salt' AND encrypted_temp_password = '$hash_pass'");
    if ($result->num_rows >0) {
        while($row = mysqli_fetch_array($result)){
            
               $status_b = $row['status'];
               $domName = $row['dom_name'];
               $domID = $row['dom_id'];
               $email = $row['email'];
        }
        if($status_b == "0"){
            $result1 = mysqli_query($conn, "SELECT * FROM dom_users WHERE email = '$email'");
            if ($result1->num_rows >0) {
                while($row1 = mysqli_fetch_array($result1)){
                    $unique_id = $row1['unique_id'];
                }
            }
            if($i == "true"){
            $sql_insert = "INSERT INTO dom_moja_spizarnia_users SET unique_id = '$unique_id', id_spizarni = '$domID'";
            if(mysqli_query($con,$sql_insert)){
                $sql_update = "UPDATE dom_moja_spizarnia_zaproszenia SET status = '1' WHERE unique_id = '$unique_id' AND id_spizarni = '$domID'";
                if(mysqli_query($con,$sql_update)){}
                $sql_update2 = "UPDATE dom_invition SET status = '1' WHERE email = '$email' AND dom_id = '$domID'";
                if(mysqli_query($con,$sql_update2)){}
                
                $message = "Pomyślnie dołączyłeś do spiżarni <b>$domName</b>";
            }
            }elseif($i == "false"){
                $sql_update = "UPDATE dom_moja_spizarnia_zaproszenia SET status = '1' WHERE unique_id = '$unique_id' AND id_spizarni = '$domID'";
                if(mysqli_query($con,$sql_update)){}
                $sql_update2 = "UPDATE dom_invition SET status = '1' WHERE email = '$email' AND dom_id = '$domID'";
                if(mysqli_query($con,$sql_update2)){}
                $message = "Pomyślnie odrzucono zaproszenie";
            }
        }else{
            $message = "Link zostal juz wykorzystany.";
        }
    }else{
        $message = "Link jest uszkodzony.";
    }
}elseif(isset($_GET['p']) && isset($_GET['s']) && isset($_GET['op']) && !empty($_GET['p']) && !empty($_GET['s']) && !empty($_GET['op'])){
    $hash_pass = $_GET['p'];
    $salt = $_GET['s'];
    $op = $_GET['op'];
    
    
    if($op == "app"){
    $result = mysqli_query($conn, "SELECT * FROM dom_app_invition WHERE salt = '$salt' AND encrypted_temp_password = '$hash_pass'");
    if ($result->num_rows >0) {
        while($row = mysqli_fetch_array($result)){
            
               $status_b = $row['status'];
               $nameDom = $row['dom_name'];
               $idDom = $row['dom_id'];
               $email = $row['email'];
        }
        if($status_b == "0"){
            $body_register = "1";
        }else{
            $body_accept = "1";
            $message = "Link zostal juz wykorzystany.";
        }
    }else{
        $body_accept = "1";
        $message = "Link jest uszkodzony.";
    }
    }else{
        $body_accept = "1";
        $message = "Link jest uszkodzony.";
    }
}else{
        $body_accept = "1";
        $message = "Link jest uszkodzony.";
}

?>

<!DOCTYPE html>
<html lang='pl'>
<head>
    <title>Spiżarnia</title>
    <link rel="stylesheet" href="../style/zaproszenia.css">
    <link rel="stylesheet" href="../nav/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<?php if($body_accept == "1") { ?>
<div class="body">
    <div class="center2">
        <h1>Spiżarnia </h1>
        <p><?php echo $message; ?></p>
    </div>
</div>
<?php } elseif($body_register == "1"){ ?>
<div class="body_form">
<div class="center" id="body_content">
<div class="content_items" id="content_items">
    <div style="width: 100%; height: auto; margin: 10px;">
    <div style="text-align: center;"><img class="login_user_round" src="../img/login_user.png"></div>
 	<div class="input-group2">
        <input type="text"  id="name" name="name" placeholder="Nazwa użytkownika" />
	</div>
    <div class="input-group2">
 		<input type="password" id="password" name="password" placeholder="Hasło" />
 	</div>
 	<div class="input-group2" style="text-align: center;">
 		<button type="button" class="button button5" id="b_register" onclick="rejestracja()">
        <span class="button__text">Utwórz konto</span>
        </button>
 	</div>
	<div class="input-group2" style="text-align: center;">
        <span id="message_txt" class="message_txt"></span>
 	</div>
 	</div>
</div>
</div>
</div>
<script>
function rejestracja2() {
   
    
    var rejestruj = "rejestruj";
    var email = "<?php echo $email ?>";
    var dom_id = "<?php echo $idDom ?>";
    var dom_name = "<?php echo $nameDom ?>";
    var input_name = document.getElementById("name");
    var name = input_name.value;
    var input_haslo = document.getElementById("password");
    var haslo = input_haslo.value;
    

        alert(rejestruj + " email: " + email + " id: " + dom_id + " domName: " + dom_name + " name: " + name + " haslo: " + haslo); 
};

function rejestracja() {
    const btn = document.getElementById("b_register");
    btn.classList.add("button--loading");
    btn.classList.add("button5_blocked");
    btn.disabled = true;
    
    var operation = "register";
    var email = "<?php echo $email ?>";
    var dom_id = "<?php echo $idDom ?>";
    var dom_name = "<?php echo $nameDom ?>";
    var input_name = document.getElementById("name");
    var name = input_name.value;
    var input_haslo = document.getElementById("password");
    var password = input_haslo.value;
    
    var rejestracja = {
        operation: operation,
        user: {
            name: name,
            email: email,
            password: password,
        }
    };

    $.ajax({
        url: "../srv.php",
        method: "post",
        headers: {
            'Content-Type': 'application/json',
        },
        data: JSON.stringify(rejestracja),
            success:function (response){
            try {
                var result_response = $.parseJSON(response);
                if (result_response.result === 'success') {
                    btn.disabled = false;
                    btn.classList.remove("button--loading");
                    
                    $('#message_txt').text(result_response.message);
                    $('#message_txt')[0].classList.remove("red_txt");
                    $('#message_txt')[0].classList.add("green_txt");
                    zaproszenie(email, dom_id, dom_name);
                }else{
                    btn.classList.remove("button--loading");
                    $('#message_txt').text(result_response.message);
                    $('#message_txt')[0].classList.remove("green_txt");
                    $('#message_txt')[0].classList.add("red_txt");
                    btn.disabled = false;
                }
            } catch (e) {
                console.error("Błąd parsowania JSON:", e);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Obsługa błędów AJAX
            console.log("Błąd AJAX: " + errorThrown);
        }
        });  
};
function zaproszenie(emailB,dId,dName) {
    const btn = document.getElementById("b_register");
    btn.classList.add("button--loading");
    btn.classList.add("button5_blocked");
    btn.disabled = true;
    
    var email = emailB;
    var dom_id = dId;
    var dom_name = dName;
    var operation = "invite2";
    var zapraszanie = {
        operation: operation,
        user: {
            email: email,
            dom_id: dom_id,
            dom_name: dom_name
        }
    };
    $.ajax({  
            url: "../srv.php",
            method: "post",
            headers: { 'Content-Type': 'application/json', },
            data: JSON.stringify(zapraszanie),
            success:function (response){
                
                    var result_response = $.parseJSON(response);
                    if (result_response.result === 'success') {
                    $('#message_txt').text(result_response.message);
                    $('#message_txt')[0].classList.remove("red_txt");
                    $('#message_txt')[0].classList.add("green_txt");
                    body = 1;btn.disabled = false;
                    btn.classList.remove("button--loading");
                }else{
                    btn.classList.remove("button--loading");
                    $('#message_txt').text(result_response.message);
                    $('#message_txt')[0].classList.remove("green_txt");
                    $('#message_txt')[0].classList.add("red_txt");
                    btn.disabled = false;
                }
            }
        });  
};

</script>
<?php } ?>
</body>
</html>