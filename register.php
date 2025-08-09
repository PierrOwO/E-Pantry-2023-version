<?php 
header('Content-type: text/html; charset=utf-8');
session_start();
  
?>
<style>
/* -------------------------------------------------------- */

.bg_center{
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 2;
  width: 100%;
  text-align: center;
  

}
.bg-image {
  /* The image used */
  background-image: url("img/bg.jpg");
    z-index: -1;

  /* Add the blur effect */
  filter: blur(8px);
  -webkit-filter: blur(8px);
  
  /* Full height */
  height: 100%; 
  
  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}


body {
  overflow: overlay;
  background: #F8F8FF;
    position: absolute;
    top: 0; bottom: 0; left: 0; right: 0;
    height: 100%;
    overflow-y: hidden;

    
    
    
  
  
}
/* -------------------------------------------------------- */

.main {
  margin-top: 45px;
  align-content: center;
}

.srodekk{
    width: 100%;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
    
    
    

  
}
@media (max-width: 5500px) {
    
.content {
    width: 25%;
    height: 50%;
  padding: 20px;
   background-color: #AEC6CF;
  border: 1px solid #91B2BE;
  border-top: none;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.4);
  border-radius: 10px 10px 10px 10px;
  
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);

}

.login_user_round{
    filter: invert(29%) sepia(11%) saturate(1424%) hue-rotate(149deg) brightness(92%) contrast(84%);
    width: 100px;
    height: 100px;
}


} 
@media (max-width: 1100px) {
  /* For mobile phones: */
 
.content {
    width: 75%;
  padding: 10px;
    background-color: #AEC6CF;
  border: 1px solid #91B2BE;
  border-top: none;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.4);
  border-radius: 10px 10px 10px 10px;
  
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);

}

.login_user_round{
    filter: invert(29%) sepia(11%) saturate(1424%) hue-rotate(149deg) brightness(92%) contrast(84%);
    width: 100px;
    height: 100px;
}


}





.input-group {
    font-family:Arial, Helvetica, sans-serif;
  margin: 10px 0px 10px 0px;
}
.input-group input {
  height: 45px;
  width: 75%;
  font-size: 18px;
  border-radius: 10px;
  border: 1px solid gray;
  display: block;
  margin:auto;
  
}


.input-group-error {
  margin: 10px 0px 10px 0px;
}
.input-group-error input {
  height: 45px;
  width: 75%;
  font-size: 18px;
  border-radius: 10px;
  border: 1px solid red;
  display: block;
  margin:auto;
}







.button {
  position: relative;

     font-family:Arial, Helvetica, sans-serif;
  width: 75%;
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 10px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 18px;
  margin: 4px 2px;
  transition-duration: 0.4s;
  cursor: pointer;
  border-radius: 10px;
}
/* zielony */
.button5 {
     font-family:Arial, Helvetica, sans-serif;
  background-color: white;
  background: rgba(0,0,0,.25);
  border: 1px solid rgba(0,0,0,.75);
  color: black; 
}

.button5:hover {
  background: rgba(0,0,0,.75);
  color: white;
}

  

.button__text {
  
}

.button--loading .button__text {
  visibility: hidden;
  opacity: 0;
}

.button--loading::after {
  content: "";
  position: absolute;
  width: 16px;
  height: 16px;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  margin: auto;
  border: 4px solid transparent;
  border-top-color: #ffffff;
  border-radius: 50%;
  animation: button-loading-spinner 1s ease infinite;
}

@keyframes button-loading-spinner {
  from {
    transform: rotate(0turn);
  }

  to {
    transform: rotate(1turn);
  }
}




.success {
  width: 75%; 
  margin: 0px auto; 
  margin: 0px auto; 
  margin-top: 10px;
  margin-bottom: 10px;
  font-size: 18px;
  padding: 10px;
  border: 1px solid #3c763d;
  color: #3c763d; 
  background: #dff0d8; 
  border-radius: 10px; 
  text-align: center;
}

.error {
  width: 75%; 
  margin: 0px auto; 
  margin-top: 10px;
  margin-bottom: 10px;
  font-size: 18px;
  padding: 10px;
  border: 1px solid #e5acb6; 
  color: #a94442; 
  background: #FFC0CB; 
  border-radius: 10px; 
  text-align: center;
}

.select-option{
    width: 80%;
    text-align: center;
}

</style>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"> </meta>
  <title>Rejestracja</title>
  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
    <link href='https://fonts.googleapis.com/css?family=Varela Round' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1"></meta>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>
<body>
    <div class="bg-image2"> </div>
<div class="bg_center2"> 
    <div class="srodek">
  
<div class="content" >
     <div class="srodekk">
         <div><center><img class="login_user_round" src="img/login_user.png"></center></div>
 	    <div id="errordiv" class="error" style="display: none;">Błąd, <b id="blad_id"></b></div>
        <div id="successdiv" class="success" style="display: none;"><b id="success_id"></div>
    <div class="input-group">
  		    <input type="text"  id="name" name="name" placeholder="Name" />
	</div>
 	<div class="input-group">
  		    <input type="email"  id="email" name="email" placeholder="Email" />
	</div>
 	<div class="input-group">
 		<input type="password" id="password" name="password" placeholder="Password" />
 	</div>
 	<center>
 	<div class="input-group">
 		<label>DOM</label>
 		<select class="select-option js-example-basic-single" name="dom" id="dom_select">
	<option value="-1">Wybierz lub wyszukaj...</option>
	<option value="1">Dom1</option>
	<option value="2">Dom2</option>
	<option value="3">Dom3</option>
	</select>
 	</div>
 	
 	<div class="input-group">
 		<button type="button" class="button button5" id="123" onclick="rejestracja(this.id)">
        <span class="button__text">Rejestracja</span>
        </button>
 	</div>
	</center>
	</div>
</div>
</div>
</div>
</body>
</html>   
<script src="js/script.js"></script>
