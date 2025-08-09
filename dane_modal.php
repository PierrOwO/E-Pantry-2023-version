<?php
header('Content-type: text/html; charset=utf-8');
include('classy.php');
$tr_tlo = "0";


if(isset($_POST['bodyZaproszenia'])){
    
    $i = "0";
       ?>
        <table class="tabela_produktow">
            <tr class="tr_naglowek">
                <th class="th_naglowek">Spiżarnia</th>
                <th class="th_naglowek">Zapraszający</th>
                <th class="th_naglowek">Data</th>
            </tr>
        <?php 
          
    $result1 = mysqli_query($conn, "SELECT * FROM dom_moja_spizarnia_zaproszenia WHERE unique_id = '$uID' AND status = '0'");
        if ($result1->num_rows >0) {
           while($row1 = mysqli_fetch_array($result1)){
                $i++;
                $tr_tlo++;
                $id_zaproszenia = $row1['id'];
                $zapraszajacy = $row1['nazwa_zapraszajacy'];
                $data = $row1['data'];
                $spizarnia = $row1['nazwa_spizarni'];
        
        if ($tr_tlo % 2 == 0) { ?>
        <tr data="zaproszenie_reakcja" id_zaproszenia="<?php echo $id_zaproszenia; ?>" class="tr_dane_k" style="background-color: #f2f2f2;">           
        <?php } else { ?>
        <tr data="zaproszenie_reakcja" id_zaproszenia="<?php echo $id_zaproszenia; ?>" class="tr_dane_k">  
       <?php } ?>
                <td class="td_dane"><?php echo $spizarnia; ?></td>
                <td class="td_dane"><?php echo $zapraszajacy; ?></td>
                <td class="td_dane"><?php echo $data; ?></td>
                
                
        </tr>
        <?php }
        }
        if($i == "0"){ ?>
            <tr class="tr_dane">
                <td colspan="3" class="td_dane">Brak zaproszeń</td>
            </tr>
        <?php
        }
        ?>
        </table>
<?php 
    
}

if(isset($_POST['bodyCzlonkowie'])){
    
    $i = "0";
    $z = "0";
       ?>
        <table class="tabela_produktow">
            <tr class="tr_naglowek">
                <th class="th_naglowek">Nazwa użytkownika</th>
                <th class="th_naglowek">Funkcja</th>
            </tr>
        <?php 
          
    $result1 = mysqli_query($conn, "SELECT * FROM dom_moja_spizarnia_users WHERE id_spizarni = '$domID'");
        if ($result1->num_rows >0) {
           while($row1 = mysqli_fetch_array($result1)){
                $id_user = $row1['unique_id'];
                $zalozyciel = $row1['zalozyciel'];
                
                if($zalozyciel == "1"){
                    $funkcja = "Założyciel";
                }else{
                    $funkcja = "Członek";
                }
                if($zalozyciel == "1" && $id_user == $uID){
                    $z = "1";
                }
                
            
        
     $result = mysqli_query($conn, "SELECT * FROM dom_users WHERE unique_id = '$id_user'");
        if ($result->num_rows >0) {
        while($row = mysqli_fetch_array($result)){
        $nazwa = $row['name'];
        $tr_tlo++;
        $i++;
        if ($tr_tlo % 2 == 0) { ?>
        <tr class="tr_dane" style="background-color: #f2f2f2;">           
        <?php } else { ?>
        <tr class="tr_dane">  
       <?php } ?>
                <td class="td_dane"><?php echo $nazwa; ?></td>
                <td class="td_dane"><?php echo $funkcja; ?></td>
                
                
        </tr>
        <?php }}}
        }
        if($i == "0"){ ?>
            <tr class="tr_dane">
                <td colspan="2" class="td_dane">Brak członków do wyświetlenia</td>
            </tr>
        <?php
        }
        if($z == "1"){ ?>
            <tr data="zapros_do_spizarni" class="tr_dane_zc">  
                <td colspan="2" class="td_dane">Zaproś do spiżarni</td>
            </tr>
        <?php
        }?>
        </table>
<?php 
    
}
if(isset($_POST['zapraszanie_do_spizarni'])){
?>
 	<div style="margin: 30px;">
 	    <div class="input-group">
 		<label>Podaj email osoby, którą zapraszasz</label>
 		<input   class="n_p_input" type="email" name="email" id="zc_input" placeholder="Email">
 		</div>
 		<div id="errordiv" style="margin-top: 10px; text-align: center; display: none; color: red; font-size: 18px"><span id="errordiv_text"></span></div>
 		<div id="successdiv" style="margin-top: 10px; text-align: center; display: none; color: green; font-size: 18px"><span id="successdiv_text"></span></div>
 	</div>
<?php
}
if(isset($_POST['odejmowanieProduktu'])){
?>
 	<div style="margin: 30px;">
 	    <div class="input-group">
 		<label>Podaj ilość produktu, którą odejmujesz</label>
 		<input   class="n_p_input" type="number" id="op_input" placeholder="Ilość">
 		</div>
 		<div id="errordiv" style="margin-top: 10px; text-align: center; display: none; color: red; font-size: 18px"><span id="errordiv_text"></span></div>
 		<div id="successdiv" style="margin-top: 10px; text-align: center; display: none; color: green; font-size: 18px"><span id="successdiv_text"></span></div>
 	</div>
<?php
}
if(isset($_POST['body_historia_zakupow'])){
    
    
    
     $result1 = mysqli_query($conn, "SELECT * FROM dom_lista_zakupow WHERE dom_id = '$domID' AND status = '0' ORDER BY id DESC");
        if ($result1->num_rows >0) {
            
            while($row1 = mysqli_fetch_array($result1)){
        $id_listy = $row1['id'];
        $numer_listy = $row1['numer'];
            
            $result = mysqli_query($conn, "SELECT * FROM dom_lista_zakupow_produkty WHERE id_listy_zakupow = '$id_listy'");
            if ($result->num_rows >0) {
                $ilosc_suma="0";
        ?>
        <div class="dane_historia">
        <table class="tabela_produktow" >
            <tr class="tr_naglowek">
                <th class="th_naglowek" style="width: 40%;">Nazwa produktu</th>
                <th class="th_naglowek" style="width: 40%;">Kategoria</th>
                <th class="th_naglowek" style="width: 10%;">Ilość</th>

            </tr>
        <?php 
        while($row = mysqli_fetch_array($result)){
        $nazwa_kategorii = $row['nazwa_kategorii'];
        $nazwa_podkategorii = $row['nazwa_podkategorii'];
        $id_podkategorii = $row['id_podkategorii'];
        if($id_podkategorii != "0"){
            $kategoria = "$nazwa_kategorii, $nazwa_podkategorii";
        }else{
            $kategoria = $nazwa_kategorii;
        }
        $tr_tlo++;
        if ($tr_tlo % 2 == 0) { ?>
        <tr class="tr_dane" style="background-color: #f2f2f2;" data="check" id_produktu="<?php echo $row['id']; ?>">           
        <?php } else { ?>
        <tr class="tr_dane" data="check" id_produktu="<?php echo $row['id']; ?>">  
       <?php } ?>
                <td class="td_dane" style="width: 40%;"><?php echo $row['nazwa_produktu']; ?></td>
                <td class="td_dane" style="width: 40%;"><?php echo $kategoria; ?></td>
                <td class="td_dane" style="width: 10%;"><?php $ilosc =  $row['ilosc']; 
                                          $jednostka =  $row['jednostka'];
                                          if($jednostka == 1){
                                          echo "$ilosc szt";
                                          }else{
                                          echo "$ilosc kg";
                                          }?></td>
        </tr>
        <?php 
        $ilosc_suma = $ilosc_suma + $row['ilosc'];

        } 
        
        ?>
        <tr class="tr_dane_akcyza">
                <td style="text-align: left;" class="td_dane"><span class="span_nr_listy" id="span_nr_listy"><?php echo $numer_listy; ?></span></th>
                <td style="text-align: right;" class="td_dane">Suma produktów:</th>
                <td class="td_dane"><?php echo $ilosc_suma; ?></th>
        </tr>
        </table>
        </div>
<?php }}}else {
            echo '<center><span style="font-size: 18px; padding: 20px;">Twoja lista zakupów jest pusta</span></center>';
        }
}
if(isset($_POST['body_lista_zakupow'])){
    
    $domid = $_POST['dom_id'];
    if($domID == "0"){
        if($domid !=0){
            $result5 = mysqli_query($conn, "SELECT * FROM dom_moja_spizarnia WHERE id = '$domid'");
             if ($result5->num_rows >0) {
              while($row5 = mysqli_fetch_array($result5)){
                $domName = $row5['nazwa'];
               
              }
              
              $domID =  $domid;
              
              session_start();
              $_SESSION['dom_id_dom'] = $domid;
              $_SESSION['dom_nazwa_dom'] = $domName;
             }
        }
    }
    $i = "0";
    ?>
        <table class="tabela_produktow">
            <tr class="tr_naglowek">
                <th class="th_naglowek" style="width: 40%;">Nazwa produktu</th>
                <th class="th_naglowek" style="width: 40%;">Kategoria</th>
                <th class="th_naglowek" style="width: 10%;">Ilość</th>
                <th class="th_naglowek" style="width: 10%;"></th>

            </tr>
        <?php 
     $result1 = mysqli_query($conn, "SELECT * FROM dom_lista_zakupow WHERE dom_id = '$domID' AND status = '1'");
        if ($result1->num_rows >0) {
            
            while($row1 = mysqli_fetch_array($result1)){
                $i++;
        $id_listy = $row1['id'];
        $numer_listy = $row1['numer'];
            
            $result = mysqli_query($conn, "SELECT * FROM dom_lista_zakupow_produkty WHERE id_listy_zakupow = '$id_listy'");
            if ($result->num_rows >0) {
                $ilosc_suma="0";
        
        while($row = mysqli_fetch_array($result)){
        $nazwa_kategorii = $row['nazwa_kategorii'];
        $nazwa_podkategorii = $row['nazwa_podkategorii'];
        $id_podkategorii = $row['id_podkategorii'];
        if($id_podkategorii != "0"){
            $kategoria = "$nazwa_kategorii, $nazwa_podkategorii";
        }else{
            $kategoria = $nazwa_kategorii;
        }
        $tr_tlo++;
        if ($tr_tlo % 2 == 0) { ?>
        <tr class="tr_dane" style="background-color: #f2f2f2;" data="check" id_produktu="<?php echo $row['id']; ?>">           
        <?php } else { ?>
        <tr class="tr_dane" data="check" id_produktu="<?php echo $row['id']; ?>">  
       <?php } ?>
                <td class="td_dane" style="width: 40%;"><?php echo $row['nazwa_produktu']; ?></td>
                <td class="td_dane" style="width: 40%;"><?php echo $kategoria; ?></td>
                <td class="td_dane" style="width: 10%;"><?php $ilosc =  $row['ilosc']; 
                                          $jednostka =  $row['jednostka'];
                                          if($jednostka == 1){
                                          echo "$ilosc szt";
                                          }else{
                                          echo "$ilosc kg";
                                          }?></td>
                <td class="td_dane" style="width: 10%;"><?php $checked = $row['checked']; 
                                    if($checked == "0"){ ?>
                                    <i check="in" id="check" id_produktu="<?php echo $row['id']; ?>" class="checks far fa-check-circle"></i>
                                    <?php }else{ ?>
                                    <i check="out" id="check" id_produktu="<?php echo $row['id']; ?>" class="checks fas fa-check-circle"></i>
                                    <?php } ?>
                                    </td>
                

        </tr>
        <?php 
        $ilosc_suma = $ilosc_suma + $row['ilosc'];

        } 
        
        ?>
        <tr class="tr_dane_akcyza">
                <td style="text-align: left;" class="td_dane"><span class="span_nr_listy" id="span_nr_listy"><?php echo $numer_listy; ?></span></th>
                <td style="text-align: right;" class="td_dane">Suma produktów:</th>
                <td class="td_dane"><?php echo $ilosc_suma; ?></th>
                <td class="td_dane"></th>
        </tr>
        </table>
        <?php }
            }
        }
        if($i == "0"){ ?>
            <tr class="tr_dane">
                <td colspan="4" class="td_dane">Lista zakupów jest pusta</td>
            </tr>
        <?php
        } ?>
        </table>
        <script>
if (typeof czyObslugaZdarzenDolaczona === 'undefined') {
    var czyObslugaZdarzenDolaczona = false;
}

if (!czyObslugaZdarzenDolaczona) {
    $(document).on('click', 'tr[data="check"]', function(event) {
        event.stopPropagation();
        var targetI = $(event.target).closest('tr').find('i');

        if (targetI.length > 0) {
            var id = targetI.attr('id_produktu');
            var check = targetI.hasClass('far');
            console.log('Kliknięto na wiersz id:', id);

            if (check) {
                var checkIn = id;
                $.ajax({  
                    url: "akcje_modal.php",  
                    method: "post",  
                    data: { checkIn: checkIn },  
                    success: function(response) {
                        var result = $.parseJSON(response);
                        if (result.status === true) {
                            targetI.removeClass('far').addClass('fas');
                            console.log('zmieniono na fas');
                            bodyListaZakupow();
                        } else {
                            alert("błąd");
                        }
                    }
                });
            } else {
                var checkOut = id;
                $.ajax({  
                    url: "akcje_modal.php",  
                    method: "post",  
                    data: { checkOut: checkOut },  
                    success: function(response) {
                        var result = $.parseJSON(response);
                        if (result.status === true) {
                            targetI.removeClass('fas').addClass('far');
                            console.log('zmieniono na far');
                            bodyListaZakupow();
                        } else {
                            alert("błąd");
                        }
                    }
                });
            }
        }
    });

    czyObslugaZdarzenDolaczona = true;
}
    
            var span_nr_listy = document.getElementById("span_nr_listy");
            span_nr_listy.addEventListener('click', functionConfirm);
            
            
function functionConfirm() {
            var confirmBox = document.getElementById("confirm");
            var confirmBox_body = document.getElementById("confirm_body");
            var tak = document.getElementById("tak");
            var nie = document.getElementById("nie");
            var anuluj = document.getElementById("anuluj");
            
            
            document.body.style.overflow = "hidden";
            var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            var confirmBoxHeight = confirmBox_body.clientHeight;
            var windowHeight = window.innerHeight;
            var topPosition = scrollTop + (windowHeight - confirmBoxHeight) * 0;
            confirmBox.style.top = topPosition + "px";
            confirmBox.style.display = "block";
            
            
            tak.addEventListener('click', zamknijListeZakupow);
            nie.addEventListener('click', modalKorekty);
            anuluj.addEventListener('click', functionConfirmBox_hide);
}
function modalKorekty() {
    functionConfirmBox_hide();
    modal_id = 4;
    modalSmall.style.display = "block";
    modalcontent_small.classList.add('modal_small-content_smaller'); 
    document.body.style.overflow = "hidden";
    var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    var modalHeight = modalcontent_small.clientHeight;
    var windowHeight = window.innerHeight;
    var topPosition = scrollTop + (windowHeight - modalHeight) * 0;
    modalSmall.style.top = topPosition + "px";
    korektaProduktu();
}
function functionConfirmBox_hide() {
            var confirmBox = document.getElementById("confirm");
            confirmBox.style.display = "none";
            document.body.style.overflow = "auto";

} 

function zamknijListeZakupow() {
    var zamknij_liste_zakupow = "zatwierdz zamknij_liste_zakupow";  
        $.ajax({  
            url:"akcje_modal.php",  
            method:"post",  
            data:{zamknij_liste_zakupow:zamknij_liste_zakupow},  
            success:function (response){
                    var result = $.parseJSON(response);
                    if (result.status === true) {
                        bodyListaZakupow();
                        functionConfirmBox_hide();
                    }else{
                        $('#message').text(result.message);
                    }
            }
        });  
};
function checkIn(id) {
    var checkIn = id;
        $.ajax({  
            url:"akcje_modal.php",  
            method:"post",  
            data:{checkIn:checkIn},  
            success:function (response){
                    var result = $.parseJSON(response);
                    if (result.status === true) {
                        bodyListaZakupow();
                    }else{
                    }
            }
        });  
};
function checkOut(id) {
    var checkOut = id;
        $.ajax({  
            url:"akcje_modal.php",  
            method:"post",  
            data:{checkOut:checkOut},  
            success:function (response){
                    var result = $.parseJSON(response);
                    if (result.status === true) {
                        bodyListaZakupow();
                    }else{
                    }
            }
        });  
};
        </script>
        <?php
}
if(isset($_POST['body_zakupy'])){
     $result = mysqli_query($conn, "SELECT * FROM dom_produkty");
        if ($result->num_rows >0) {
        ?>
        <body>
        <table class="tabela_produktow">
            <tr class="tr_naglowek">
                <th class="th_naglowek">Nazwa produktu</th>
                <th class="th_naglowek">Kategoria</th>
                <th class="th_naglowek">Dostępna ilość</th>
            </tr>
        <?php 
        while($row = mysqli_fetch_array($result)){
            $id_produktu = $row['id'];
        $result2 = mysqli_query($conn, "SELECT * FROM dom_produkty_dostepne WHERE dom_id = '$domID' AND id_produktu = '$id_produktu'");
        if ($result2->num_rows >0) {
        while($row2 = mysqli_fetch_array($result2)){
            $ilosc_b = $row2['ilosc'];
            $ilosc = $ilosc_b;
            
        }}else{$ilosc = "0";}
        ?>
        
        <tr class="tr-container">
      <td colspan="3">
        <div class="level1">x <button class="btn_dodaj_class" id_wiersza="<?php echo $row['id']; ?>" >+</button></div>
        <div class="level2">
          <div class="extra-column"><?php echo $row['nazwa']; ?></div>
          <div class="extra-column"><?php echo $row['nazwa_kategorii']; ?></div>
          <div class="extra-column"><?php echo $ilosc ?></div>
        </div>
      </td>
    </tr>
        <?php } ?>
        </table>
        <script>
        
        //var b_dodajDoListy = document.getElementById("btn_dodaj");
        //b_dodajDoListy.addEventListener("click", function () {
    (function() {
        const buttons = document.querySelectorAll('.btn_dodaj_class');

    buttons.forEach(button => {
        button.addEventListener('click', function(event) {
            const id_wiersza = event.target.getAttribute('id_wiersza');
            id_produktu_zakupy = id_wiersza;
            console.log("Przycisk klikniety, id: " + id_wiersza);
            modal_id = 3;
            modalSmall.style.display = "block";
            modalcontent_small.classList.add('modal_small-content_xxs'); 
            document.body.style.overflow = "hidden";
            var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            var modalHeight = modalcontent_small.clientHeight;
            var windowHeight = window.innerHeight;
            var topPosition = scrollTop + (windowHeight - modalHeight) * 0;
            modalSmall.style.top = topPosition + "px";
            dodawanieDoListy(id_wiersza);
        });
    });
    
        
    })();
        </script>
    </body>
        <?php }
}
if(isset($_POST['bodyHistoriaProduktow'])){
    $i = "0";
     ?>
        <table class="tabela_produktow">
            <tr class="tr_naglowek">
                <th class="th_naglowek">Kto</th>
                <th class="th_naglowek">Nazwa</th>
                <th class="th_naglowek">Kategorie</th>
                <th class="th_naglowek">Ilość</th>
                <th class="th_naglowek">Data</th>
            </tr>
        <?php 
        if($domID != "0"){
        $result1 = mysqli_query($conn, "SELECT * FROM dom_historia WHERE dom_id = '$domID' ORDER BY id DESC");
        if ($result1->num_rows >0) {
           $i++;
            while($row1 = mysqli_fetch_array($result1)){
                $id_produktu = $row1['id_produktu'];
                $kto = $row1['kto'];
                $ilosc = $row1['ilosc'];
                $data = $row1['data'];
                $nazwa = $row1['nazwa'];


        
     $result = mysqli_query($conn, "SELECT * FROM dom_produkty WHERE id = '$id_produktu'");
        if ($result->num_rows >0) {
        
        while($row = mysqli_fetch_array($result)){
            $nazwa_kategorii = $row['nazwa_kategorii'];
            $nazwa_podkategorii = $row['nazwa_podkategorii'];
            $jednostka = $row['jednostka'];
            if($nazwa_podkategorii == "0"){
                $kategoria = "$nazwa_kategorii";
            }else {
                $kategoria = "$nazwa_kategorii, $nazwa_podkategorii";
            }
        $tr_tlo++;
        if ($tr_tlo % 2 == 0) { ?>
        <tr class="tr_dane" style="background-color: #f2f2f2;">           
        <?php } else { ?>
        <tr class="tr_dane">  
       <?php } ?>
                <td class="td_dane"><?php echo $kto; ?></td>
                <td class="td_dane"><?php echo $nazwa; ?></td>
                <td class="td_dane"><?php echo $kategoria; ?></td>
                <td class="td_dane"><?php if($jednostka == 1){
                                          echo "$ilosc szt";
                                          }else{
                                          echo "$ilosc kg";
                                          }?></td>
                <td class="td_dane"><?php echo $data; ?></td>
                
        </tr>
        <?php }}}
         }
            
        
        if($i == "0"){ ?>
        <tr class="tr_dane">
            <td colspan="5" class="td_dane">Brak produktów do wyświetlenia</td>
        </tr>
<?php   }
            
        }else { ?>
        <tr class="tr_dane">
            <td colspan="5" class="td_dane">Spiżarnia nie została wybrana</td>
        </tr>
<?php   } ?>
    </table>
<?php
}
if(isset($_POST['body_produkty'])){
    $i = "0";
     ?>
        <table class="tabela_produktow">
            <tr class="tr_naglowek">
                <th class="th_naglowek">Nazwa produktu</th>
                <th class="th_naglowek">Kategoria</th>
                <th class="th_naglowek">Dostępna ilość</th>
            </tr>
        <?php 
        if($domID != "0"){
        $result1 = mysqli_query($conn, "SELECT * FROM dom_produkty ORDER BY nazwa ASC");
        if ($result1->num_rows >0) {
           
            while($row1 = mysqli_fetch_array($result1)){
                $id_produktu = $row1['id'];
                $nazwa_produktu = $row1['nazwa'];
                $nazwa_kategorii = $row1['nazwa_kategorii'];
                $jednostka =  $row1['jednostka'];
            
        
     $result = mysqli_query($conn, "SELECT * FROM dom_produkty_dostepne WHERE dom_id = '$domID' AND id_produktu = '$id_produktu'");
        if ($result->num_rows >0) {
        $i++;
        while($row = mysqli_fetch_array($result)){
            
        $ilosc_produktu = $row['ilosc'];
        $id_produkt = $row['id'];
        $tr_tlo++;
        if ($tr_tlo % 2 == 0) { ?>
        <tr data="odejmowanie_produktu" id_produktu="<?php echo $id_produkt; ?>" class="tr_dane" style="background-color: #f2f2f2;">           
        <?php } else { ?>
        <tr data="odejmowanie_produktu" id_produktu="<?php echo $id_produkt; ?>" class="tr_dane">  
        <?php } ?>
                <td class="td_dane"><?php echo $nazwa_produktu; ?></td>
                <td class="td_dane"><?php echo $nazwa_kategorii; ?></td>
                <td class="td_dane"><?php if($jednostka == 1){
                                          echo "$ilosc_produktu szt";
                                          }else{
                                          echo "$ilosc_produktu kg";
                                          }?></td>
                
        </tr>
        <?php }}}
         }
            
        
        if($i == "0"){ ?>
        <tr class="tr_dane">
            <td colspan="3" class="td_dane">Brak produktów do wyświetlenia</td>
        </tr>
<?php   }
            
        }else { ?>
        <tr class="tr_dane">
            <td colspan="3" class="td_dane">Spiżarnia nie została wybrana</td>
        </tr>
<?php   } ?>
    </table>
<?php
}
if(isset($_POST['body_kategorie'])){
    $i = "0";
?>
        <table class="tabela_produktow">
            <tr class="tr_naglowek">
                <th class="th_naglowek">Nazwa kategorii</th>
                <th class="th_naglowek">Suma produktow</th>
            </tr>
<?php 
        $result_s = mysqli_query($conn, "SELECT * FROM dom_moja_spizarnia WHERE id = '$domID'");
        if ($result_s->num_rows >0) {
            $i++;
            
     $result = mysqli_query($conn, "SELECT * FROM dom_kategorie ORDER BY nazwa ASC");
        if ($result->num_rows >0) {
        while($row = mysqli_fetch_array($result)){
            $id_kategorii = $row['id'];
            
        $tr_tlo++;
        $suma = "0";
        
        $result2 = mysqli_query($conn, "SELECT * FROM dom_produkty WHERE id_kategorii = '$id_kategorii' ");
        if ($result2->num_rows >0) {
        while($row2 = mysqli_fetch_array($result2)){
            $id_produktu = $row2['id'];
            $result3 = mysqli_query($conn, "SELECT * FROM dom_produkty_dostepne WHERE dom_id = '$domID' AND id_produktu = '$id_produktu' ");
            if ($result3->num_rows >0) {
            while($row3 = mysqli_fetch_array($result3)){
                $ilosc_p = $row3['ilosc'];
                $suma= $suma + $ilosc_p;
            }}
        }}
        if ($tr_tlo % 2 == 0) { ?>
        <tr data="kategoria" id_kategorii="<?php echo $row['id']; ?>" class="tr_dane_k" style="background-color: #f2f2f2;" >           
        <?php } else { ?>
        <tr data="kategoria" id_kategorii="<?php echo $row['id']; ?>" class="tr_dane_k">  
       <?php } ?>
                <td class="td_dane"><?php echo $row['nazwa']; ?></td>
                <td class="td_dane"><?php echo $suma; ?></td>
        </tr>
        <?php } ?>
        
        <?php }}
        if($i == "0"){?>
        <tr class="tr_dane">
            <td colspan="2" class="td_dane">Nie wybrano spiżarni</td>
        </table>
<?php }
}
if(isset($_POST['produktyKategorii'])){
    $id_kategorii = $_POST['produktyKategorii'];
    $i = "0";
    
    $result1 = mysqli_query($conn, "SELECT * FROM dom_produkty WHERE id_kategorii = '$id_kategorii' ORDER BY nazwa ASC");
        if ($result1->num_rows >0) {
            ?>
        <table class="tabela_produktow">
            <tr class="tr_naglowek">
                <th class="th_naglowek">Nazwa produktu</th>
                <th class="th_naglowek">Kategoria</th>
                <th class="th_naglowek">Dostępna ilość</th>
            </tr>
        <?php 
            while($row1 = mysqli_fetch_array($result1)){
                $id_produktu = $row1['id'];
                $nazwa_produktu = $row1['nazwa'];
                $nazwa_kategorii = $row1['nazwa_kategorii'];
                $jednostka =  $row1['jednostka'];
            
        
     $result = mysqli_query($conn, "SELECT * FROM dom_produkty_dostepne WHERE dom_id = '$domID' AND id_produktu = '$id_produktu'");
        if ($result->num_rows >0) {
        
        while($row = mysqli_fetch_array($result)){
        $ilosc_produktu = $row['ilosc'];
        $tr_tlo++;
        $i++;
        if ($tr_tlo % 2 == 0) { ?>
        <tr data="odejmowanie_produktu" id_produktu="<?php echo $id_produkt; ?>" class="tr_dane" style="background-color: #f2f2f2;">           
        <?php } else { ?>
        <tr data="odejmowanie_produktu" id_produktu="<?php echo $id_produkt; ?>" class="tr_dane">  
        <?php } ?>
                <td class="td_dane"><?php echo $nazwa_produktu; ?></td>
                <td class="td_dane"><?php echo $nazwa_kategorii; ?></td>
                <td class="td_dane"><?php if($jednostka == 1){
                                          echo "$ilosc_produktu szt";
                                          }else{
                                          echo "$ilosc_produktu kg";
                                          }?></td>
                
        </tr>
        <?php }}}
        if($i == "0"){ ?>
            <tr class="tr_dane">
                <td colspan="3" class="td_dane">Brak produktów do wyświetlenia</td>
            </tr>
        <?php
        } ?>
        </table>
        <?php } else{ echo "<center><h4>Brak produktów do wyświetlenia</h4></center>"; }
}
if(isset($_POST['dodawanie_produktu'])){

    $Sql = "SELECT * FROM dom_produkty";
    $result = $conn->query($Sql);

?>
 <div style="margin: 30px;">
 		<label>Produkt</label>
	<select class="select-option_n-p_normal js-example-basic-single" id="n-p-select">
	<option value="-1">Wyszukaj...</option>
		<?php
		if ($result->num_rows >0) {
		while($row = mysqli_fetch_array($result)){ ?>
	        <option value="<?php echo $row["id"] ?>">
	        <?php echo $row["nazwa"] ?>, <?php $nazwa_kategorii =  $row["nazwa_kategorii"];
	                                   $nazwa_podkategorii = $row["nazwa_podkategorii"]; 
	                                   if ($nazwa_podkategorii != "0"){
	                                   echo "$nazwa_kategorii > $nazwa_podkategorii";
	                                   }else{
	                                   echo "$nazwa_kategorii";
	                                   }?></option>
		<?php }} ?>
	</select>
 	    <div class="input-group">
 		<label>Ilość</label>
 		<input   class="n_p_input" type="number" id="DP_ilosc"placeholder="Ilość dodawana">
 		</div>
 		<div id="errordiv" style="margin-top: 10px; text-align: center; display: none; color: red; font-size: 18px"><span id="errordiv_text"></span></div>
 		<div id="successdiv" style="margin-top: 10px; text-align: center; display: none; color: green; font-size: 18px"><span id="successdiv_text"></span></div>
 </div>

<?php
}
if(isset($_POST['dodawanie_spizarni'])){
?>
 <div style="margin: 30px;">
 	    <div class="input-group">
 		<label>Nazwa Spiżarni</label>
 		<input   class="n_p_input" type="text" id="ns_input" placeholder="Nazwa spiżarni">
 		</div>
 		<div id="errordiv" style="margin-top: 10px; text-align: center; display: none; color: red; font-size: 18px"><span id="errordiv_text"></span></div>
 		<div id="successdiv" style="margin-top: 10px; text-align: center; display: none; color: green; font-size: 18px"><span id="successdiv_text"></span></div>
 </div>
<?php
}
if(isset($_POST['dodawanie_do_listy_zakupow'])){

    $Sql = "SELECT * FROM dom_produkty";
    $result = $conn->query($Sql);

?>
 <div style="margin: 30px;">
 	<label>Produkt</label>
	<select class="select-option_n-p_normal js-example-basic-single" id="n-p-select">
	<option value="-1">Wyszukaj...</option>
		<?php
		if ($result->num_rows >0) {
		while($row = mysqli_fetch_array($result)){ ?>
	        <option value="<?php echo $row["id"] ?>"><?php echo $row["nazwa"] ?>, <?php $nazwa_kategorii =  $row["nazwa_kategorii"];
	                                                                                    $nazwa_podkategorii = $row["nazwa_podkategorii"]; 
	                                                                                        if ($nazwa_podkategorii != "0"){
	                                                                                        echo "$nazwa_kategorii > $nazwa_podkategorii";
	                                                                                        }else{
	                                                                                        echo "$nazwa_kategorii";
	                                                                                        }?></option>
		<?php }} ?>
	</select>
	    <div class="input-group">
 		<label>Ilość</label>
 		<input   class="n_p_input" type="number" id="DP_ilosc"placeholder="Ilość do kupienia">
 		</div>
 		<div id="errordiv" style="margin-top: 10px; text-align: center; display: none; color: red; font-size: 18px"><span id="errordiv_text"></span></div>
 		<div id="successdiv" style="margin-top: 10px; text-align: center; display: none; color: green; font-size: 18px"><span id="successdiv_text"></span></div>
 </div>
<?php
}
if(isset($_POST['body_korekta_produktu'])){

    
$sql_lista_id = "SELECT * FROM dom_lista_zakupow WHERE dom_id = '$domID' AND status = '1'";
$result_lista_id = $con->query($sql_lista_id);
  if ($result_lista_id->num_rows >0) {
      while($row_lista_id = mysqli_fetch_array($result_lista_id)){
          $id_listy = $row_lista_id['id'];
      }
      
      $sql_lista = "SELECT * FROM dom_lista_zakupow_produkty WHERE id_listy_zakupow = '$id_listy' ORDER BY nazwa_produktu ASC";
        $result_lista = $con->query($sql_lista);
        

?>
 <div style="margin: 30px;">
 		<label>Produkt</label>
	<select class="select-option_n-p_normal js-example-basic-single" id="n-p-select">
	<option value="-1">Wyszukaj...</option>
		<?php
		if ($result_lista->num_rows >0) {
            while($row_lista = mysqli_fetch_array($result_lista)){ ?>
	        <option value="<?php echo $row_lista["id"] ?>"><?php echo $row_lista["nazwa_produktu"] ?>, <?php $nazwa_kategorii =  $row_lista["nazwa_kategorii"];
	                                                                                    $nazwa_podkategorii = $row_lista["nazwa_podkategorii"]; 
	                                                                                        if ($nazwa_podkategorii != "0"){
	                                                                                        echo "$nazwa_kategorii > $nazwa_podkategorii";
	                                                                                        }else{
	                                                                                        echo "$nazwa_kategorii";
	                                                                                        }?></option>
		<?php }} ?>
	</select>
	
 	    <div class="input-group">
 		<label>Ilość</label>
 		<input   class="n_p_input" type="number" id="DP_ilosc"placeholder="Ilość kupiona">
 		</div>
 		<div id="errordiv" style="margin-top: 10px; text-align: center; display: none; color: red; font-size: 18px"><span id="errordiv_text"></span></div>
 		<div id="successdiv" style="margin-top: 10px; text-align: center; display: none; color: green; font-size: 18px"><span id="successdiv_text"></span></div>
 </div>
<?php
}
}






if(isset($_POST['bodyAktywacjaKonta'])){
?>
    <div style="margin: 30px;">
        <div class="input-group4">
             <label>Kod aktywacyjny</label>
            <input   class="n_p_input" type="text" id="activation_code" placeholder="Kod aktywacyjny">
        </div>
        <div id="errordiv" style="margin-top: 10px; text-align: center; display: none; color: red; font-size: 18px"><span id="errordiv_text"></span></div>
 		<div id="successdiv" style="margin-top: 10px; text-align: center; display: none; color: green; font-size: 18px"><span id="successdiv_text"></span></div>
 
    </div>
<?php
}
if(isset($_POST['bodyResethasla'])){
?>
    <div style="margin: 30px;">
        <div class="input-group4">
             <label>Podaj email</label>
            <input   class="n_p_input" type="email" id="pr_email" placeholder="Email">
        </div>
        <div id="errordiv" style="margin-top: 10px; text-align: center; display: none; color: red; font-size: 18px"><span id="errordiv_text"></span></div>
 		<div id="successdiv" style="margin-top: 10px; text-align: center; display: none; color: green; font-size: 18px"><span id="successdiv_text"></span></div>
 
    </div>
<?php
}
if(isset($_POST['bodyResethaslaKod'])){
?>
    <div style="margin: 30px;">
        <div id="timer" style="text-align: center; font-size: 24px;">05:00</div>
        <div class="input-group4">
            <label>Podaj kod otrzymany na maila</label>
            <input   class="n_p_input" type="text" id="pr_kod" placeholder="Kod aktywacyjny">
        </div>
        <div class="input-group4">
            <label>Podaj nowe hasło</label>
            <input   class="n_p_input" type="password" id="pr_haslo" placeholder="Nowe hasło">
        </div>
        <div id="errordiv" style="margin-top: 10px; text-align: center; display: none; color: red; font-size: 18px"><span id="errordiv_text"></span></div>
 		<div id="successdiv" style="margin-top: 10px; text-align: center; display: none; color: green; font-size: 18px"><span id="successdiv_text"></span></div>
 
    </div>
<?php
}

if(isset($_POST['dodawanie_do_listy_zakupow2'])){ ?>
 <div style="width: 92%; height: 90%; border: gray; border-radius: 10px; background: #F5F5F5">

 	<div style="margin-left: 30px; margin-right: 30px; margin-top: 30px; ">
 		<label>Ilość do kupienia</label>
 		<input   class="n_p_input" type="number" id="DP_ilosc"placeholder="Ilość">
 		</div>
 		<div id="errordiv" style="margin-top: 10px; text-align: center; display: none; color: red; font-size: 18px"><span id="errordiv_text"></span></div>
 		<div id="successdiv" style="margin-top: 10px; text-align: center; display: none; color: green; font-size: 18px"><span id="successdiv_text"></span></div>
 	</div>

 </div>
<?php
}
if(isset($_POST['nowy_produkt'])){
    
  
    
    $sql2 = "SELECT * FROM dom_podkategorie";
    $result2 = $conn->query($sql2);

?>

 	<div style="margin: 30px; ">
 	    <div class="input-group">
 		<label>Nazwa produktu</label>
 		<input   class="n_p_input" type="text" id="DP_nazwa" placeholder="Nazwa produktu">
 		</div>
 		<div class="input-group">
 		<label>Kategoria</label>
 		<div class="select-group">
	<select class="select-option_n-p_normal js-example-basic-single" id="n-p-select">
	        <option value="-1">Wyszukaj...</option>
		    <?php
		    if ($result2->num_rows >0) { ?>
		  <optgroup label="Podkategorie">
		      <?php  
		    while($row2 = mysqli_fetch_array($result2)){
		        $id_podkategorii = $row2['id'];
		        $nazwa_podkategorii = $row2['nazwa'];
		        $id_kategorii = $row2['id_kategorii']; 
		        $Sql = "SELECT * FROM dom_kategorie WHERE id = '$id_kategorii'";
                $result = $conn->query($Sql);
                    if ($result->num_rows >0) {
		            while($row = mysqli_fetch_array($result)){
		                $nazwa_kategorii = $row['nazwa'];
		    }
		    ?>
	        <option 
                data-id-podkategorii="<?php echo $id_podkategorii; ?>"
                data-id-kategorii="<?php echo $id_kategorii; ?>"
                data-nazwa-podkategorii="<?php echo $nazwa_podkategorii; ?>"
                data-nazwa-kategorii="<?php echo $nazwa_kategorii; ?>">
                <?php echo "$nazwa_kategorii=>$nazwa_podkategorii" ?>
            </option>   
		    <?php }} ?> 
		  </optgroup>
		    <?php } ?>
		  <optgroup label="Kategorie">
		  <?php
		  $Sql3 = "SELECT * FROM dom_kategorie";
                $result3 = $conn->query($Sql3);
                    if ($result3->num_rows >0) {
		            while($row3 = mysqli_fetch_array($result3)){
		                $nazwa_kategorii = $row3['nazwa'];
		                $id_kategorii = $row3['id'];
		                $id_podkategorii = "0";
		                $nazwa_podkategorii = "0";
		  ?>
		    <option 
                data-id-podkategorii="<?php echo $id_podkategorii; ?>"
                data-id-kategorii="<?php echo $id_kategorii; ?>"
                data-nazwa-podkategorii="<?php echo $nazwa_podkategorii; ?>"
                data-nazwa-kategorii="<?php echo $nazwa_kategorii; ?>">
                <?php echo "$nazwa_kategorii" ?>
            </option>   
		  <?php }} ?>
		  </optgroup>
		  	    </select>
 		</div>
 		</div>
 		<div class="input-group">
 		<label>Jednostka</label>
 		<div class="select-group">
 		<select class="select-option_n-p_normal js-example-basic-single" style="margin-left: 2px;" id="select_jednostka">
	        <option value="1">szt</option>
	        <option value="2">kg</option>
	    </select>
 		</div>
 		</div>
 		<div id="errordiv" style="margin-top: 10px; text-align: center; display: none; color: red; font-size: 18px"><span id="errordiv_text"></span></div>
 		<div id="successdiv" style="margin-top: 10px; text-align: center; display: none; color: green; font-size: 18px"><span id="successdiv_text"></span></div>
 	</div>
<?php
}
?>