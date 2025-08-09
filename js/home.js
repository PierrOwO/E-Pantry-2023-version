
    var dom = "0";
    var domID = "0";
document.addEventListener("DOMContentLoaded", function() {
    var fragment = window.location.hash.substring(1);
    if (fragment) {
    var values = fragment.split("-");
    var kod = "0";
    
    kod = values[0];
    domID = values[1];

    if(dom === "0"){
        if (kod === "lz") {
            dom = 1;
         console.log("hash :", kod);
         bodyListaZakupow();
        }
    }
    console.log("fragment :", fragment);
    console.log("values :", values);
    console.log("kod :", kod);
    console.log("id :", domID);
    console.log("dom :", dom);

    
    }
});




////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
const trContainers = document.querySelectorAll('.tr-container');

    trContainers.forEach((container) => {
      container.addEventListener('mouseenter', () => {
        const level2 = container.querySelector('.level2');
        level2.style.transform = 'translateX(-50px)';
      });

      container.addEventListener('mouseleave', () => {
        const level2 = container.querySelector('.level2');
        level2.style.transform = 'translateX(0)';
      });
    });

var modal_id = 0;
var id_produktu_zakupy = 0;
var dane_body = 0;

if(dane_body === 0){
    bodyKategorie();
}

////////////////////////////////////////////////////////////////////////////////
//modalSmall
////////////////////////////////////////////////////////////////////////////////
var op_id_produktu = "0";
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
    if(modal_id === 1){
        zatwierdz_produkt();
    }else if(modal_id === 2){
        zatwierdzDodawanieProduktu();
    }else if(modal_id === 3){
        zatwierdzDodawanieDoListyZakupow();
    }else if(modal_id === 4){
        zatwierdzKorekteProduktu();
    }else if(modal_id === 5){
        zatwierdzNowaSpizarnia();
    }else if(modal_id === 6){
        zatwierdzZaproszenie();
    }else if(modal_id === 7){
        zatwierdzOdejmowanie();
    }else if(modal_id === 10){
        zatwierdzNowyProdukt();
    }
        
        
});
$(document).on('click', 'a[data="moja_spizarnia"]', function() {
    $('#dane').html("");
    var id_spizarni = $(this).attr('id_spizarni');
    var nazwa_spizarni = $(this).attr('nazwa_spizarni');
    wczytajSpizarnie(id_spizarni, nazwa_spizarni);
});
$(document).on('click', 'a[data-toggle="nowa_spizarnia"]', function() {
    modal_id = 5;
    modalSmall.style.display = "block";
    modalcontent_small.classList.add('modal_small-content_auto'); 
    document.body.style.overflow = "hidden";
  var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    var modalHeight = modalcontent_small.clientHeight;
    var windowHeight = window.innerHeight;
    var topPosition = scrollTop + (windowHeight - modalHeight) * 0;
    modalSmall.style.top = topPosition + "px";
   nowaSpizarnia();
});

$(document).on('click', 'a[data="show_users"]', function() {
    $('#dane').html("");
   bodyCzlonkowie();
});
$(document).on('click', 'a[data="zaproszenia"]', function() {
    $('#dane').html("");
   bodyZaproszenia();
});
$(document).on('click', 'a[data="kategoria"]', function() {
    $('#dane').html("");
    var id_kategorii = $(this).attr('id_kategorii');
   produktyKategorii(id_kategorii);
});

$(document).on('click', 'tr[data="kategoria"]', function() {
    $('#dane').html("");
    var id_kategorii = $(this).attr('id_kategorii');
   produktyKategorii(id_kategorii);
});

$(document).on('click', 'a[data-toggle="dodaj_produkt"]', function() {
    modal_id = 2;
    modalSmall.style.display = "block";
    modalcontent_small.classList.add('modal_small-content_auto'); 
    document.body.style.overflow = "hidden";
  var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    var modalHeight = modalcontent_small.clientHeight;
    var windowHeight = window.innerHeight;
    var topPosition = scrollTop + (windowHeight - modalHeight) * 0;
    modalSmall.style.top = topPosition + "px";
   dodawanieProduktu();
});
$(document).on('click', 'a[data-toggle="nowy_produkt"]', function() {
    modal_id = 10;
    modalSmall.style.display = "block";
    modalcontent_small.classList.add('modal_small-content_auto'); 
    document.body.style.overflow = "hidden";
  var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    var modalHeight = modalcontent_small.clientHeight;
    var windowHeight = window.innerHeight;
    var topPosition = scrollTop + (windowHeight - modalHeight) * 0;
    modalSmall.style.top = topPosition + "px";
   nowyProdukt();
});

$(document).on('click', 'a[data-toggle="historia_produktu"]', function() {
    $('#dane').html("");
   bodyHistoriaProduktow();
});




$(document).on('click', 'a[data-toggle="body_produkty"]', function() {
    $('#dane').html("");
    bodyProdukty();
});
$(document).on('click', 'a[data-toggle="body_kategorie"]', function() {
    $('#dane').html("");
    bodyKategorie();
});
$(document).on('click', 'a[data-toggle="body_zakupy"]', function() {
    modal_id = 3;
    modalSmall.style.display = "block";
    modalcontent_small.classList.add('modal_small-content_auto'); 
    document.body.style.overflow = "hidden";
  var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    var modalHeight = modalcontent_small.clientHeight;
    var windowHeight = window.innerHeight;
    var topPosition = scrollTop + (windowHeight - modalHeight) * 0;
    modalSmall.style.top = topPosition + "px";
    dodawanieDoListy();
});
$(document).on('click', 'a[data-toggle="body_historia_zakupow"]', function() {
    $('#dane_body').html("");
    bodyHistoriaZakupow();
});
$(document).on('click', 'a[data-toggle="body_lista_zakupow"]', function() {
    $('#dane').html("");
    bodyListaZakupow();
});
$(document).on('click', 'a[data-toggle="logout"]', function() {
    $('#dane').html("");
    wyloguj();
});
$(document).on('click', 'tr[data="zapros_do_spizarni"]', function() {
    modal_id = 6;
    modalSmall.style.display = "block";
    modalcontent_small.classList.add('modal_small-content_auto'); 
    document.body.style.overflow = "hidden";
  var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    var modalHeight = modalcontent_small.clientHeight;
    var windowHeight = window.innerHeight;
    var topPosition = scrollTop + (windowHeight - modalHeight) * 0;
    modalSmall.style.top = topPosition + "px";
    zapraszanieDoSpizarni();
});
$(document).on('click', 'tr[data="odejmowanie_produktu"]', function() {
    modal_id = 7;
    var id_produktu = $(this).attr('id_produktu');
    modalSmall.style.display = "block";
    modalcontent_small.classList.add('modal_small-content_auto'); 
    document.body.style.overflow = "hidden";
  var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    var modalHeight = modalcontent_small.clientHeight;
    var windowHeight = window.innerHeight;
    var topPosition = scrollTop + (windowHeight - modalHeight) * 0;
    modalSmall.style.top = topPosition + "px";
    op_id_produktu = id_produktu;
    odejmowanieProduktu();
});
$(document).on('click', 'tr[data="zaproszenie_reakcja"]', function() {
    var id_zaproszenia = $(this).attr('id_zaproszenia');
    var confirmBox = document.getElementById("confirm_z");
    var confirmBox_body = document.getElementById("confirm_body_z");
    var tak = document.getElementById("tak_z");
    var nie = document.getElementById("nie_z");
    var anuluj = document.getElementById("anuluj_z");
            
            
    document.body.style.overflow = "hidden";
    var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    var confirmBoxHeight = confirmBox_body.clientHeight;
    var windowHeight = window.innerHeight;
    var topPosition = scrollTop + (windowHeight - confirmBoxHeight) * 0;
    confirmBox.style.top = topPosition + "px";
    confirmBox.style.display = "block";
            
    //tak.addEventListener('click', dolaczDoSpizarni(id_zaproszenia));
    //nie.addEventListener('click', odmowDolaczenia(id_zaproszenia));
    tak.addEventListener('click', function() {
        dolaczDoSpizarni(id_zaproszenia);
    });
    nie.addEventListener('click', function() {
        odmowDolaczenia(id_zaproszenia);
    });
    
    anuluj.addEventListener('click', close_confirm);
});

function confirmZapraszanie(email){
    var email_z = email;
    var confirmBox = document.getElementById("confirm_z2");
    var confirmBox_body = document.getElementById("confirm_body_z2");
    var tak = document.getElementById("tak_z2");
    var anuluj = document.getElementById("anuluj_z2");
            
            
    document.body.style.overflow = "hidden";
    var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    var confirmBoxHeight = confirmBox_body.clientHeight;
    var windowHeight = window.innerHeight;
    var topPosition = scrollTop + (windowHeight - confirmBoxHeight) * 0;
    confirmBox.style.top = topPosition + "px";
    confirmBox.style.display = "block";
            
    tak.addEventListener('click', function() {
        zaprosDoAplikacji(email);
    });
    
    anuluj.addEventListener('click', close_confirm2);
}
////////////////////////////////////////////////////////////////////////////////
// FUNKCJE                                                                    //
////////////////////////////////////////////////////////////////////////////////
function scrollTopSmooth(){
    window.scrollTo({
    top: 0,
    behavior: 'smooth'
});
}
function closeModalSmall() {
    center_small.classList.add("closing");
  setTimeout(function() {
    center_small.classList.remove("closing");
    modal_id = 0;
    op_id_produktu = "0";
    document.body.style.overflow = "auto";
    modalSmall.style.display = "none";
    $('#m_title_small').text('');
    $('#m_body_small').html('');
  }, 200); 
    
}
function close_confirm() {
    var confirmBox = document.getElementById("confirm_z");
    confirmBox.style.display = "none";
    document.body.style.overflow = "auto";
} 
function close_confirm2() {
    var confirmBox = document.getElementById("confirm_z2");
    confirmBox.style.display = "none";
    document.body.style.overflow = "auto";
} 
// BODY HTML //////////////////////////////////////////////////////////////////

function bodyHistoriaZakupow() {
        var body_historia_zakupow = "body body_historia_zakupow";
            $.ajax({  
                url:"dane_modal.php",  
                method:"post",  
                data:{body_historia_zakupow:body_historia_zakupow},  
                success:function(data){  
                    
                    $('#dane').html(data);
    
                    
                    navLinks.style.left = "-100%";
                },
                error: function() {
                alert('Błąd wczytywania');
                }
           });  
};
function bodyListaZakupow() {
    //$('#dane_body').html('wczytywanie...');
        var body_lista_zakupow = "body zakupy";
        var dom_id = domID;
            $.ajax({  
                url:"dane_modal.php",  
                method:"post",  
                data:{body_lista_zakupow:body_lista_zakupow, dom_id:dom_id},  
                success:function(data){  
                    $('#dane_body').html(data);
    
                    navLinks.style.left = "-100%";
                },
                error: function() {
                alert('Błąd wczytywania');
                }
           });  
};
function bodyZakupy() {
    
        var body_zakupy = "body zakupy";
            $.ajax({  
                url:"dane_modal.php",  
                method:"post",  
                data:{body_zakupy:body_zakupy},  
                success:function(data){  
                    $('#dane_body').html(data);
    
                    navLinks.style.left = "-100%";
                },
                error: function() {
                alert('Błąd wczytywania');
                }
           });  
};
function bodyCzlonkowie() {
    
        var bodyCzlonkowie = "body czlonkowie";
            $.ajax({  
                url:"dane_modal.php",  
                method:"post",  
                data:{bodyCzlonkowie:bodyCzlonkowie},  
                success:function(data){  
                    $('#dane_body').html(data);
    
                    navLinks.style.left = "-100%";
                },
                error: function() {
                alert('Błąd wczytywania');
                }
           });  
};
function bodyZaproszenia() {
    
        var bodyZaproszenia = "body czlonkowie";
            $.ajax({  
                url:"dane_modal.php",  
                method:"post",  
                data:{bodyZaproszenia:bodyZaproszenia},  
                success:function(data){  
                    $('#dane_body').html(data);
    
                    navLinks.style.left = "-100%";
                },
                error: function() {
                alert('Błąd wczytywania');
                }
           });  
};
function bodyHistoriaProduktow() {
    
        var bodyHistoriaProduktow = "body historia produktow";
            $.ajax({  
                url:"dane_modal.php",  
                method:"post",  
                data:{bodyHistoriaProduktow:bodyHistoriaProduktow},  
                success:function(data){  
                    $('#dane_body').html(data);
    
                    navLinks.style.left = "-100%";
                },
                error: function() {
                alert('Błąd wczytywania');
                }
           });  
};
function bodyProdukty() {
    
        var body_produkty = "body produkty";
            $.ajax({  
                url:"dane_modal.php",  
                method:"post",  
                data:{body_produkty:body_produkty},  
                success:function(data){  
                    $('#dane_body').html(data);
    
                    navLinks.style.left = "-100%";
                },
                error: function() {
                alert('Błąd wczytywania');
                }
           });  
};
function bodyKategorie() {
    
        var body_kategorie = "body kategorie";
            $.ajax({  
                url:"dane_modal.php",  
                method:"post",  
                data:{body_kategorie:body_kategorie},  
                success:function(data){  
                    $('#dane_body').html(data);
    
                    navLinks.style.left = "-100%";
                },
                error: function() {
                alert('Błąd wczytywania');
                }
           });  
};
function produktyKategorii(id) {
    
        var produktyKategorii = id;
            $.ajax({  
                url:"dane_modal.php",  
                method:"post",  
                data:{produktyKategorii:produktyKategorii},  
                success:function(data){  
                    $('#dane_body').html(data);
    
                    navLinks.style.left = "-100%";
                },
                error: function() {
                alert('Błąd wczytywania');
                }
           });  
};
// BODY MODAL //////////////////////////////////////////////////////////////////
function dodawanieProduktu() {
    
        var dodawanie_produktu = "dodawanie produktu";
            $.ajax({  
                url:"dane_modal.php",  
                method:"post",  
                data:{dodawanie_produktu:dodawanie_produktu},  
                success:function(data){  
                    b_zatwierdz_small.style.display = "block"; 
                    $('#m_title_small').text('Dodawanie produktu');
                    $('#m_body_small').html(data);
                    wczytajSelect2();
                },
                error: function() {
                alert('Błąd wczytywania');
                }
           });  
};
function zapraszanieDoSpizarni() {
    
        var zapraszanie_do_spizarni = "dodawanie spizarni";
            $.ajax({  
                url:"dane_modal.php",  
                method:"post",  
                data:{zapraszanie_do_spizarni:zapraszanie_do_spizarni},  
                success:function(data){  
                    b_zatwierdz_small.style.display = "block"; 
                    $('#m_title_small').text('Zapraszanie do spiżarni');
                    $('#m_body_small').html(data);
                },
                error: function() {
                alert('Błąd wczytywania');
                }
           });  
};
function odejmowanieProduktu() {
    
        var odejmowanieProduktu = "odejmowanie Produktu";
            $.ajax({  
                url:"dane_modal.php",  
                method:"post",  
                data:{odejmowanieProduktu:odejmowanieProduktu},  
                success:function(data){  
                    b_zatwierdz_small.style.display = "block"; 
                    $('#m_title_small').text('Odejmowanie produktu');
                    $('#m_body_small').html(data);
                },
                error: function() {
                alert('Błąd wczytywania');
                }
           });  
};

function nowaSpizarnia() {
    
        var dodawanie_spizarni = "dodawanie spizarni";
            $.ajax({  
                url:"dane_modal.php",  
                method:"post",  
                data:{dodawanie_spizarni:dodawanie_spizarni},  
                success:function(data){  
                    b_zatwierdz_small.style.display = "block"; 
                    $('#m_title_small').text('Nowa spiżarnia');
                    $('#m_body_small').html(data);
                    wczytajSelect2();
                },
                error: function() {
                alert('Błąd wczytywania');
                }
           });  
};
function korektaProduktu() {
    
        var body_korekta_produktu = "body_korekta_produktu";
            $.ajax({  
                url:"dane_modal.php",  
                method:"post",  
                data:{body_korekta_produktu:body_korekta_produktu},  
                success:function(data){  
                        console.log("modal wczytany, id: " + body_korekta_produktu);

                    b_zatwierdz_small.style.display = "block"; 
                    $('#m_title_small').text('Dodawanie produktu');
                    $('#m_body_small').html(data);
                    wczytajSelect2();
                },
                error: function() {
                alert('Błąd wczytywania');
                }
           });  
};
function dodawanieDoListy() {
    
        var dodawanie_do_listy_zakupow = "dodawanie_do_listy_zakupow";
            $.ajax({  
                url:"dane_modal.php",  
                method:"post",  
                data:{dodawanie_do_listy_zakupow:dodawanie_do_listy_zakupow},  
                success:function(data){  
                        console.log("modal wczytany, id: " + dodawanie_do_listy_zakupow);

                    b_zatwierdz_small.style.display = "block"; 
                    $('#m_title_small').text('Dodawanie do listy');
                    $('#m_body_small').html(data);
                    wczytajSelect2();
                },
                error: function() {
                alert('Błąd wczytywania');
                }
           });  
};
function nowyProdukt() {
    
        var nowy_produkt = "nowy produkt";
            $.ajax({  
                url:"dane_modal.php",  
                method:"post",  
                data:{nowy_produkt:nowy_produkt},  
                success:function(data){  
                    b_zatwierdz_small.style.display = "block"; 
                    $('#m_title_small').text('Dodawanie produktu');
                    $('#m_body_small').html(data);
                    wczytajSelect2();
                    wczytajSelect2_2();
                },
                error: function() {
                alert('Błąd wczytywania');
                }
           });  
};
function wczytajSelect2(){
    $('#n-p-select').select2({
                    dropdownParent: $('#myModalSmall')
                    });
    
    console.log("wczytano select2");

}
function wczytajSelect2_2(){
    select_jednostka
    $('#DP_sklep_select').select2({
                    dropdownParent: $('#myModalSmall')
                    });
    console.log("wczytano select2.2");

}
// ZATWIERDZANIE MODAL //////////////////////////////////////////////////////////////////
function zatwierdzNowyProdukt() {
b_zatwierdz_small.classList.add('loading'); 

    var dodajDoBazy = "zatwierdz nowy produkt";  
    var selectOption = document.getElementById("n-p-select");
    var nazwa_podkategorii = selectOption.options[selectOption.selectedIndex].dataset.nazwaPodkategorii;
    var nazwa_kategorii = selectOption.options[selectOption.selectedIndex].dataset.nazwaKategorii;
    var id_podkategorii = selectOption.options[selectOption.selectedIndex].dataset.idPodkategorii;
    var id_kategorii = selectOption.options[selectOption.selectedIndex].dataset.idKategorii;
    
    var select_option_jednostka = document.getElementById("select_jednostka");
    var jednostka = select_option_jednostka.value;
    var input_nazwa= document.getElementById("DP_nazwa");
    var nazwa_produktu = input_nazwa.value;

        $.ajax({  
            url:"akcje_modal.php",  
            method:"post",  
            data:{dodajDoBazy:dodajDoBazy,
            nazwa_produktu:nazwa_produktu,
            jednostka:jednostka,
            nazwa_podkategorii:nazwa_podkategorii,
            nazwa_kategorii:nazwa_kategorii,
            id_podkategorii:id_podkategorii,
            id_kategorii:id_kategorii},  
            success:function (response){
                
                    var result = $.parseJSON(response);
                    if (result.status === true) {
                        $('#errordiv').hide()
                        $('#successdiv').show()
                        $('#successdiv_text').text(result.message);
                        b_zatwierdz_small.classList.remove('loading');

                    }else{
                        b_zatwierdz_small.classList.remove('loading');
                        $('#errordiv').show()
                        $('#successdiv').hide()
                        $('#errordiv_text').text(result.message);
                        
                    }
            }
        });  
};



function zatwierdzDodawanieProduktu() {
b_zatwierdz_small.classList.add('loading'); 

    var zatwierdzDodawanieProduktu = "zatwierdz aktualizacje produktu";  
    var select_option = document.getElementById("n-p-select");
    var produkt = select_option.value;
    var input_ilosc = document.getElementById("DP_ilosc");
    var ilosc = input_ilosc.value;

        $.ajax({  
            url:"akcje_modal.php",  
            method:"post",  
            data:{zatwierdzDodawanieProduktu:zatwierdzDodawanieProduktu, produkt:produkt, ilosc:ilosc},  
            success:function (response){
                
                    var result = $.parseJSON(response);
                    if (result.status === true) {
                        $('#errordiv').hide()
                        $('#successdiv').show()
                        $('#successdiv_text').text(result.message);
                        b_zatwierdz_small.classList.remove('loading');

                    }else{
                        b_zatwierdz_small.classList.remove('loading');
                        $('#errordiv').show()
                        $('#successdiv').hide()
                        $('#errordiv_text').text(result.message);
                        
                    }
            }
        });  
};
function wczytajSpizarnie(id, nazwa) {
    var wczytajSpizarnie = "zatwierdz nowa spizarnia"
    var id_spizarni = id;
    var nazwa_spizarni = nazwa;
    $.ajax({  
            url:"akcje_modal.php",  
            method:"post",  
            data:{wczytajSpizarnie:wczytajSpizarnie, id_spizarni:id_spizarni, nazwa_spizarni:nazwa_spizarni},  
            success:function (response){
                    var result = $.parseJSON(response);
                    if (result.status === true) {
                        window.location.reload();    
                    }else{
                        alert(result.message);
                        
                    }
            }
        });  
};

function dolaczDoSpizarni(id) {
    var dolaczDoSpizarni = "zatwierdz nowa spizarnia"
    var id_zaproszenia = id;
    $.ajax({  
            url:"akcje_modal.php",  
            method:"post",  
            data:{dolaczDoSpizarni:dolaczDoSpizarni, id_zaproszenia:id_zaproszenia},  
            success:function (response){
                
                    var result = $.parseJSON(response);
                    if (result.status === true) {
                        alert(result.message);
                    }else{
                        alert(result.message);
                    }
            }
        });  
};
function odmowDolaczenia(id) {
    b_zatwierdz_small.classList.add('loading'); 
    var odmowDolaczenia = "zatwierdz nowa spizarnia"
    var id_zaproszenia = id;
    $.ajax({  
            url:"akcje_modal.php",  
            method:"post",  
            data:{odmowDolaczenia:odmowDolaczenia, id_zaproszenia:id_zaproszenia},  
            success:function (response){
                
                    var result = $.parseJSON(response);
                    if (result.status === true) {
                        alert(result.message);
                    }else{
                        alert(result.message);
                    }
            }
        });  
};
function zatwierdzOdejmowanie() {
    b_zatwierdz_small.classList.add('loading'); 
    var odejmowanieProduktu = "zatwierdz nowa spizarnia"
    var input_ilosc = document.getElementById("op_input");
    var ilosc = input_ilosc.value;
    produkt = op_id_produktu;
    $.ajax({  
            url:"akcje_modal.php",  
            method:"post",  
            data:{odejmowanieProduktu:odejmowanieProduktu, ilosc:ilosc, produkt:produkt},  
            success:function (response){
                
                    var result = $.parseJSON(response);
                    if (result.status === true) {
                        $('#errordiv').hide()
                        $('#successdiv').show()
                        $('#successdiv_text').text(result.message);
                        b_zatwierdz_small.classList.remove('loading');
                        

                    }else{
                        b_zatwierdz_small.classList.remove('loading');
                        $('#errordiv').show()
                        $('#successdiv').hide()
                        $('#errordiv_text').text(result.message);
                        
                    }
            }
        });  
};

function zatwierdzZaproszenie2x() {
    b_zatwierdz_small.classList.add('loading'); 
    var zaprosDoSpizarni = "zatwierdz nowa spizarnia"
    var input_email = document.getElementById("zc_input");
    var email = input_email.value;
    $.ajax({  
            url:"akcje_modal.php",  
            method:"post",  
            data:{zaprosDoSpizarni:zaprosDoSpizarni, email:email},  
            success:function (response){
                
                    var result = $.parseJSON(response);
                    if (result.status === true) {
                        $('#errordiv').hide()
                        $('#successdiv').show()
                        $('#successdiv_text').text(result.message);
                        b_zatwierdz_small.classList.remove('loading');
                        

                    }else{
                        b_zatwierdz_small.classList.remove('loading');
                        $('#errordiv').show()
                        $('#successdiv').hide()
                        $('#errordiv_text').text(result.message);
                        
                    }
            }
        });  
};
function zatwierdzZaproszenie() {
    b_zatwierdz_small.classList.add('loading'); 

    var email = $("#zc_input").val();
    var invite = "invite";
    var zapraszanie = {
        operation: invite,
        user: {
            email: email
        }
    };
    console.log("email: " + email);

    $.ajax({  
            url: "srv.php",
            method: "post",
            headers: { 'Content-Type': 'application/json', },
            data: JSON.stringify(zapraszanie),
            success:function (response){
                
                    var result_response = $.parseJSON(response);
                    if (result_response.result === 'success') {
                        $('#errordiv').hide()
                        $('#successdiv').show()
                        $('#successdiv_text').text(result_response.message);
                        b_zatwierdz_small.classList.remove('loading');
                        

                    }else if (result_response.result === 'notexist') {
                        $('#errordiv').show()
                        $('#successdiv').hide()
                        $('#errordiv_text').text(result_response.message);
                        b_zatwierdz_small.classList.remove('loading');
                        confirmZapraszanie(email);
                        

                    }else{
                        b_zatwierdz_small.classList.remove('loading');
                        $('#errordiv').show()
                        $('#successdiv').hide()
                        $('#errordiv_text').text(result_response.message);
                        
                    }
            }
        });  
};
function zaprosDoAplikacji(email){
    close_confirm2();
b_zatwierdz_small.classList.add('loading'); 

    var email = email;
    var inviteToApp = "inviteToApp";
    var zapraszanie = {
        operation: inviteToApp,
        user: {
            email: email
        }
    };
    console.log("email: " + email);

    $.ajax({  
            url: "srv.php",
            method: "post",
            headers: { 'Content-Type': 'application/json', },
            data: JSON.stringify(zapraszanie),
            success:function (response){
                
                    var result_response = $.parseJSON(response);
                    if (result_response.result === 'success') {
                        $('#errordiv').hide()
                        $('#successdiv').show()
                        $('#successdiv_text').text(result_response.message);
                        b_zatwierdz_small.classList.remove('loading');
                    }else{
                        b_zatwierdz_small.classList.remove('loading');
                        $('#errordiv').show()
                        $('#successdiv').hide()
                        $('#errordiv_text').text(result_response.message);
                        
                    }
            }
        });  
};
function zatwierdzNowaSpizarnia() {
    b_zatwierdz_small.classList.add('loading'); 
    var nowaSpizarnia = "zatwierdz nowa spizarnia"
    var input_nazwa = document.getElementById("ns_input");
    var nazwa = input_nazwa.value;
    $.ajax({  
            url:"akcje_modal.php",  
            method:"post",  
            data:{nowaSpizarnia:nowaSpizarnia, nazwa:nazwa},  
            success:function (response){
                
                    var result = $.parseJSON(response);
                    if (result.status === true) {
                        $('#errordiv').hide()
                        $('#successdiv').show()
                        $('#successdiv_text').text(result.message);
                        b_zatwierdz_small.classList.remove('loading');
                        

                    }else{
                        b_zatwierdz_small.classList.remove('loading');
                        $('#errordiv').show()
                        $('#successdiv').hide()
                        $('#errordiv_text').text(result.message);
                        
                    }
            }
        });  
};
function zatwierdzKorekteProduktu() {
b_zatwierdz_small.classList.add('loading'); 

    var korekta_produktu = "zatwierdz korekta_produktu";  
    var select_option = document.getElementById("n-p-select");
    var produkt = select_option.value;
    var input_ilosc = document.getElementById("DP_ilosc");
    var ilosc = input_ilosc.value;

        $.ajax({  
            url:"akcje_modal.php",  
            method:"post",  
            data:{korekta_produktu:korekta_produktu, produkt:produkt, ilosc:ilosc},  
            success:function (response){
                
                    var result = $.parseJSON(response);
                    if (result.status === true) {
                        $('#errordiv').hide()
                        $('#successdiv').show()
                        $('#successdiv_text').text(result.message);
                        b_zatwierdz_small.classList.remove('loading');
                        bodyListaZakupow();

                    }else{
                        b_zatwierdz_small.classList.remove('loading');
                        $('#errordiv').show()
                        $('#successdiv').hide()
                        $('#errordiv_text').text(result.message);
                        
                    }
            }
        });  
};
function zatwierdzDodawanieDoListyZakupow() {
b_zatwierdz_small.classList.add('loading'); 

    var dodaj_produkt_do_listy = "zatwierdz dodaj_produkt_do_listy";  
    var select_option = document.getElementById("n-p-select");
    var produkt = select_option.value;
    var input_ilosc = document.getElementById("DP_ilosc");
    var ilosc = input_ilosc.value;

        $.ajax({  
            url:"akcje_modal.php",  
            method:"post",  
            data:{dodaj_produkt_do_listy:dodaj_produkt_do_listy, produkt:produkt, ilosc:ilosc},  
            success:function (response){
                
                    var result = $.parseJSON(response);
                    if (result.status === true) {
                        $('#errordiv').hide()
                        $('#successdiv').show()
                        $('#successdiv_text').text(result.message);
                        b_zatwierdz_small.classList.remove('loading');
                        $('#dane').html("");
                        bodyListaZakupow();

                    }else{
                        b_zatwierdz_small.classList.remove('loading');
                        $('#errordiv').show()
                        $('#successdiv').hide()
                        $('#errordiv_text').text(result.message);
                        
                    }
            }
        });  
};
function zatwierdz_produkt() {
b_zatwierdz_small.classList.add('loading'); 

    var zatwierdz_nowy_produkt = "zatwierdz produkt";  
    var select_option = document.getElementById("n-p-select");
    var produkt = select_option.value;
    var input_ilosc = document.getElementById("DP_ilosc");
    var ilosc = input_ilosc.value;
    var input_nazwa = document.getElementById("DP_nazwa");
    var nazwa = input_nazwa.value;
    var input_cena = document.getElementById("DP_cena");
    var cena = input_cena.value;
    var select_sklep = document.getElementById("DP_sklep_select");
    var sklep = select_sklep.value;
    
    var select_jednostka = document.getElementById("select_jednostka");
    var jednostka = select_jednostka.value;
     var kaucja = "0.0";
    var checkbox = document.getElementById('DP_checkbox_kaucja');
    var inputKaucja = document.getElementById('DP_kaucja');
    if (checkbox.checked) {
        kaucja = inputKaucja.value;
        console.log("checked, value: " + kaucja + ", jednostka: " + jednostka + ", produkt: " + produkt);

    }else {
                console.log("not checked, value: " + kaucja + ", jednostka: " + jednostka + ", produkt: " + produkt);

    }
    
    
        $.ajax({  
            url:"akcje_modal.php",  
            method:"post",  
            data:{zatwierdz_nowy_produkt:zatwierdz_nowy_produkt, nazwa:nazwa, produkt:produkt, ilosc:ilosc, sklep:sklep, cena:cena, jednostka:jednostka, kaucja:kaucja},  
            success:function (response){
                
                    var result = $.parseJSON(response);
                    if (result.status === true) {
                        $('#errordiv').hide()
                        $('#successdiv').show()
                        $('#successdiv_text').text(result.message);
                        b_zatwierdz_small.classList.remove('loading');
                    }else{
                        b_zatwierdz_small.classList.remove('loading');
                        $('#errordiv').show()
                        $('#successdiv').hide()
                        $('#errordiv_text').text(result.message);
                    }
            }
        });  
};
function dodajDoListy(id) {
    var dodaj_do_listy_zakupow = id;
b_zatwierdz_small.classList.add('loading'); 
    
    var input_ilosc = document.getElementById("DP_ilosc");
    var ilosc = input_ilosc.value;
        $.ajax({  
            url:"akcje_modal.php",  
            method:"post",  
            data:{dodaj_do_listy_zakupow:dodaj_do_listy_zakupow, ilosc:ilosc},  
            success:function (response){
                
                    var result = $.parseJSON(response);
                    if (result.status === true) {
                        $('#errordiv').hide()
                        $('#successdiv').show()
                        $('#successdiv_text').text(result.message);
                        b_zatwierdz_small.classList.remove('loading');
                    }else{
                        b_zatwierdz_small.classList.remove('loading');
                        $('#errordiv').show()
                        $('#successdiv').hide()
                        $('#errordiv_text').text(result.message);
                    }
            }
        });  
};


function wyloguj() {
    var logout = "wyloguj";

        $.ajax({  
            url:"akcje_modal.php",  
            method:"post",  
            data:{logout:logout},  
            success:function (data){
                        console.log("success");
                        window.location.reload();

            },
            error:function() {
                        alert("blad podczas przetwarzania");
                    }
        });  
};


