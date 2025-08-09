var input_name = document.getElementById("name");
var input_email = document.getElementById("email");
var input_password = document.getElementById("password");
var btn_login = document.getElementById("b_login");
var btn_register = document.getElementById("b_register");
var txt_login_register = document.getElementById("login_register_txt");
var txt_reset_password = document.getElementById("reset_password_txt");
var body_content = document.getElementById("body_content");

var body = 0;
if(body === 0){
    input_name.style.display = "none";
    btn_register.style.display = "none";
    txt_login_register.textContent = 'Rejestracja';
    body = 1;
}
txt_login_register.addEventListener('click', function() {
   if(body === 2){
    $('#message_txt').text('');
    input_name.style.display = "none";
    btn_register.style.display = "none";
    btn_login.style.display = "inline-block";
    txt_reset_password.style.display = "inline-block";
    txt_login_register.classList.remove('margin_left_auto');
    txt_login_register.textContent = 'Rejestracja';
    body = 1;
}
else if(body === 1){
    $('#message_txt').text('');
    input_name.style.display = "block";
    btn_login.style.display = "none";
    btn_register.style.display = "inline-block";
    txt_reset_password.style.display = "none";
    txt_login_register.classList.add('margin_left_auto');
    txt_login_register.textContent = 'Logowanie';
    body = 2;
}
});

function logowanie(id) {
    console.log("wcisnieto przycisk x");
   $('#message_txt').text('');

    const btn = document.getElementById("b_login");
    btn.classList.add("button--loading");
    btn.classList.add("button5_blocked");
    btn.disabled = true;

    var email = $("#email").val();
    var password = $("#password").val();
    var login = "login";
    var logowanie = {
        operation: login,
        user: {
            email: email,
            password: password
        }
    };

    $.ajax({
        url: "srv.php",
        method: "post",
        headers: { 'Content-Type': 'application/json', },
        data: JSON.stringify(logowanie),
        success: function (response) {
            var result_response = $.parseJSON(response);
            if (result_response.result === 'notactivated') {
                const btn = document.getElementById("b_login");
                btn.classList.remove("button--loading");
                btn.classList.remove("button5_blocked");
                btn.disabled = false;
                var response_unique_id = result_response.user.unique_id;
                var response_email = result_response.user.email;
                otworz_modal(response_unique_id, response_email);
                
            }else if (result_response.result === 'success') {
                $('#message_txt').text(result_response.message);
                $('#message_txt')[0].classList.remove("red_txt");
                $('#message_txt')[0].classList.add("green_txt");
                setTimeout(function () {
                        window.location.reload();
                        }, 250);
            } else {
                btn.classList.remove("button--loading");
                btn.classList.remove("button5_blocked");
                $('#message_txt').text(result_response.message);
                $('#message_txt')[0].classList.remove("green_txt");
                $('#message_txt')[0].classList.add("red_txt");
                btn.disabled = false;
                

            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Obsługa błędów AJAX
            console.log("Błąd AJAX: " + errorThrown);
        }
    });
}

function rejestracja(id) {

    const btn = document.getElementById("b_register");
    btn.classList.add("button--loading");

    var name = $("#name").val();
    var email = $("#email").val();
    var password = $("#password").val();
    var register = "register";

    var rejestracja = {
        operation: register,
        user: {
            name: name,
            email: email,
            password: password,
        }
    };

    $.ajax({
        url: "srv.php",
        method: "post",
        headers: {
            'Content-Type': 'application/json',
        },
        data: JSON.stringify(rejestracja),

        success: function (response) {
            try {
            var result_response = $.parseJSON(response);
            if (result_response.result === 'success') {
                $('#message_txt').text(result_response.message);
                $('#message_txt')[0].classList.remove("red_txt");
                $('#message_txt')[0].classList.add("green_txt");
                
                input_name.style.display = "none";
                btn_register.style.display = "none";
                btn_login.style.display = "inline-block";
                txt_reset_password.style.display = "inline-block";
                txt_login_register.classList.remove('margin_left_auto');
                txt_login_register.textContent = 'Rejestracja';
                body = 1;btn.disabled = false;
                btn.classList.remove("button--loading");
                
            } else {
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
}



////////////////////////////////////////////////////////////////////////////////
//modalSmall
////////////////////////////////////////////////////////////////////////////////
var r_email = "";
var r_unique_id = "";
var modal_id = "0";
var p_r_email = "";

var modalSmall = document.getElementById("myModalSmall");
var modalcontent_small = document.getElementById("content_small");
var modalBodySmall = document.getElementById("m_body_small");

var closeButtonSmall = document.getElementById("close_small");
var centerSmall = document.getElementById("center_small");
var b_close_small = document.getElementById("b_close_small");
var b_zatwierdz_small = document.getElementById("b_zatwierdz_small");

    var spinnerContainer = document.getElementById('spinner-container');
    var buttonText = document.getElementById('button__text');
    
closeButtonSmall.addEventListener('click', closeModalSmall);
b_close_small.addEventListener('click', closeModalSmall);

b_zatwierdz_small.addEventListener('click', function() {
  if(modal_id === "1"){
  console.log("kliknieto zatwierdzanie aktywacji");
  zatwierdzKod();
  }else if(modal_id === "2"){
  console.log("kliknieto reset hasla");
  wyslijEmail();
  }else if(modal_id === "3"){
  console.log("kliknieto wysylanie nowego hasla");
  wyslijNoweHaslo();
  }
});


////////////////////////////////////////////////////////////////////////////////
// FUNKCJE                                                                    //
////////////////////////////////////////////////////////////////////////////////
txt_reset_password.addEventListener('click', function() {
    modal_id="2";
    modalSmall.style.display = "block";
    //modalcontent_small.classList.add('modal_small-content_auto'); 
    document.body.style.overflow = "hidden";
  var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    var modalHeight = modalcontent_small.clientHeight;
    var windowHeight = window.innerHeight;
    var topPosition = scrollTop + (windowHeight - modalHeight) * 0;
    modalSmall.style.top = topPosition + "px";
    bodyResethasla();
});

function otworz_modal(id, email){
     r_email = email;
     r_unique_id = id;
     modal_id="1";
    modalSmall.style.display = "block";
    //modalcontent_small.classList.add('modal_small-content_auto'); 
    document.body.style.overflow = "hidden";
  var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    var modalHeight = modalcontent_small.clientHeight;
    var windowHeight = window.innerHeight;
    var topPosition = scrollTop + (windowHeight - modalHeight) * 0;
    modalSmall.style.top = topPosition + "px";
    bodyAktywacjaKonta();
}
function closeModalSmall() {
    center_small.classList.add("closing");
  setTimeout(function() {
    center_small.classList.remove("closing");
    modal_id = 0;
    p_r_email = "";
    document.body.style.overflow = "auto";
    modalSmall.style.display = "none";
    $('#m_title_small').text('');
    $('#m_body_small').html('');
  }, 200); 
}

function zatwierdzKod() {
b_zatwierdz_small.classList.add('loading'); 

var email = r_email;
var aktywacja = $("#activation_code").val();

a_u_id = r_unique_id;

var activation = "activation";
    var zatwierdz_kod = {
        operation: activation,
        user: {
            email: email,
            aktywacja: aktywacja
        }
    };
        $.ajax({  
            url: "srv.php",
            method: "post",
            headers: { 'Content-Type': 'application/json', },
            data: JSON.stringify(zatwierdz_kod),
            success:function (response){
                
                    var result_response = $.parseJSON(response);
                    if (result_response.result === "success") {
                        b_zatwierdz_small.classList.remove('loading');
                        closeModalSmall();
                        logowanie(a_u_id);

                    }else{
                        b_zatwierdz_small.classList.remove('loading');
                        $('#errordiv').show()
                        $('#successdiv').hide()
                        $('#errordiv_text').text(result_response.message);
                
                        
                    }
            }
        });  
}
function bodyAktywacjaKonta() {
    
        var bodyAktywacjaKonta = "nowy produkt";
            $.ajax({  
                url:"dane_modal.php",  
                method:"post",  
                data:{bodyAktywacjaKonta:bodyAktywacjaKonta},  
                success:function(data){  
                    b_zatwierdz_small.style.display = "block"; 
                    $('#m_title_small').text('Aktywacja konta');
                    $('#m_body_small').html(data);
                    
                },
                error: function() {
                alert('Błąd wczytywania');
                }
           });  
};

function bodyResethasla() {
    
        var bodyResethasla = "bodyResethasla";
            $.ajax({  
                url:"dane_modal.php",  
                method:"post",  
                data:{bodyResethasla:bodyResethasla},  
                success:function(data){  
                    b_zatwierdz_small.style.display = "block"; 
                    $('#m_title_small').text('Reset hasła');
                    $('#m_body_small').html(data);
                    
                },
                error: function() {
                alert('Błąd wczytywania');
                }
           });  
};

function bodyResethaslaKod() {
    modal_id="3";
        var bodyResethaslaKod = "bodyResethaslaKod";
            $.ajax({  
                url:"dane_modal.php",  
                method:"post",  
                data:{bodyResethaslaKod:bodyResethaslaKod},  
                success:function(data){  
                    b_zatwierdz_small.style.display = "block"; 
                    $('#m_body_small').html(data);
                    timerStart();
                },
                error: function() {
                alert('Błąd wczytywania');
                }
           });  
};
///////////
//FUNKCJE//
///////////

function wyslijEmail() {
b_zatwierdz_small.classList.add('loading'); 
$('#message_txt').text('');
    
    var email = $("#pr_email").val();
    var resPassReq = "resPassReq";
    var reset_hasla = {
        operation: resPassReq,
        user: {
            email: email,
        }
    };
    
    p_r_email = email;
    
    $.ajax({
        url: "srv.php",
        method: "post",
        headers: { 'Content-Type': 'application/json', },
        data: JSON.stringify(reset_hasla),
        success: function (response) {
            var result_response = $.parseJSON(response);
             if (result_response.result === 'success') {
                 bodyResethaslaKod();
                $('#errordiv').hide()
                $('#successdiv').show()
                $('#successdiv_text').text(result_response.message);
                b_zatwierdz_small.classList.remove('loading');
                
            } else {
                
                $('#errordiv').show()
                $('#successdiv').hide()
                $('#errordiv_text').text(result_response.message);
                b_zatwierdz_small.classList.remove('loading');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Błąd AJAX: " + errorThrown);
        }
    });
}
function wyslijNoweHaslo() {
b_zatwierdz_small.classList.add('loading'); 
$('#message_txt').text('');
    var email = p_r_email;
    var code = $("#pr_kod").val();
    var password = $("#pr_haslo").val();
    var resPass = "resPass";
    var reset_hasla_kod = {
        operation: resPass,
        user: {
            email: email,
            password: password,
            code: code,
        }
    };

    $.ajax({
        url: "srv.php",
        method: "post",
        headers: { 'Content-Type': 'application/json', },
        data: JSON.stringify(reset_hasla_kod),
        success: function (response) {
            var result_response = $.parseJSON(response);
             if (result_response.result === 'success') {
                $('#errordiv').hide()
                $('#successdiv').show()
                $('#successdiv_text').text(result_response.message);
                b_zatwierdz_small.classList.remove('loading');
            } else {
                
                $('#errordiv').show()
                $('#successdiv').hide()
                $('#errordiv_text').text(result_response.message);
                b_zatwierdz_small.classList.remove('loading');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Błąd AJAX: " + errorThrown);
        }
    });
}


function timerStart() {
    let seconds = 5 * 60;
    const timerElement = document.getElementById("timer");
    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;

        const formattedMinutes = String(minutes).padStart(2, '0');
        const formattedSeconds = String(remainingSeconds).padStart(2, '0');

        return `${formattedMinutes}:${formattedSeconds}`;
    }

    // Aktualizuj czas co sekundę
    const intervalId = setInterval(function() {
        seconds--;
        timerElement.textContent = formatTime(seconds);

        // Zatrzymaj odliczanie po osiągnięciu 0 sekund
        if (seconds <= 0) {
            clearInterval(intervalId);
            closeModalSmall();
        }
    }, 1000);
};