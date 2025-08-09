<?php
header('Content-type: text/html; charset=utf-8');
if (isset($_GET['s']) && isset($_GET['sn']) && !empty($_GET['s']) && !empty($_GET['sn'])) {
    session_start();
    $_SESSION['dom_id_dom'] = $_GET['s'];
    $_SESSION['dom_nazwa_dom'] = $_GET['sn'];
}
include('classy.php');
  if (!isset($_SESSION['dom_id_u'])) {
  	header('location: login.php'); }
  	
  	$result = mysqli_query($conn, "SELECT * FROM dom_kategorie ORDER BY nazwa ASC");
  	$result_s = mysqli_query($conn, "SELECT * FROM dom_moja_spizarnia ORDER BY nazwa ASC");
        
?>
<!DOCTYPE html>
<html lang="pl" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Spiżarnia</title>
    <link rel="stylesheet" href="nav/style.css">
    <link rel="stylesheet" href="style/check.css">
    <link rel="stylesheet" href="style/confirmbox.css">
    <link rel="stylesheet" href="style/modal2.css">
    <link rel="stylesheet" href="style/home.css">
    <link rel="stylesheet" href="style/slide_row.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>
<body>
    <nav>
    <div class="navbar">
      <i class='bx bx-menu'></i>
      <div class="logo"><a href="#"><?php echo $domName; ?></a></div>
      <div class="nav-links">
        <div class="sidebar-logo">
          <span class="logo-name"><?php echo $domName; ?></span>
          <i class='bx bx-x' ></i>
        </div>
        <ul class="links scroll_view">
            <li <?php if($domID == "0"){ ?> style="display:none"<?php } ?>>
            <a data="show_users" href="#msu">Członkowie</a>
            <i class='bx bxs-chevron-down czlonkowie-arrow arrow'></i>
            <ul class="czlonkowie-sub-menu sub-menu">
            <li><a  data="show_users" href="#ns">Pokaż członków</a></li>
            <li><a  data="zaproszenia" href="#ns">Zaproszenia</a></li>
            </ul>
            </li>
            <li>
            <a data-toggle="body_spizarnie" href="#ms">Moje spiżarnie</a>
            <i class='bx bxs-chevron-down spizarnie-arrow arrow'></i>
            <ul class="spizarnie-sub-menu sub-menu">
                <div style="height: auto; max-height: 35vh; overflow-x: hidden; overflow-y: auto;">
                <?php if ($result_s->num_rows >0) { 
                while($row_s = mysqli_fetch_array($result_s)){
                $id_spizarni = $row_s['id'];
                $nazwa = $row_s['nazwa'];
                
                $result_s1 = mysqli_query($conn, "SELECT * FROM dom_moja_spizarnia_users WHERE id_spizarni = '$id_spizarni' AND unique_id = '$uID'");
                if ($result_s1->num_rows >0) {  ?>
                <li><a  xdata="moja_spizarnia" xnazwa_spizarni="<?php echo $nazwa; ?>" xid_spizarni="<?php echo $id_spizarni; ?>" href="?s=<?php echo $id_spizarni; ?>&&sn=<?php echo $nazwa; ?>"><?php echo $nazwa; ?></a></li>
                <?php }} ?>
                </div> 
                <?php }else{?>
                <li><a href="#null">brak dostępnych spiżarni</a></li>
                <?php } ?>
                <li><a  data-toggle="nowa_spizarnia"  href="#ns">Nowa spiżarnia</a></li>
            </ul>
            </li>
            <li <?php if($domID == "0"){ ?> style="display:none"<?php } ?>>
            <a data-toggle="body_kategorie" href="#k">Kategorie</a>
            <i class='bx bxs-chevron-down kategorie-arrow arrow'></i>
            <ul class="kategorie-sub-menu sub-menu">
                <div style="height: auto; max-height: 35vh; overflow-x: hidden; overflow-y: auto;">
                <?php if ($result->num_rows >0) { 
                while($row = mysqli_fetch_array($result)){?>
                
                <li><a  data="kategoria" id_kategorii="<?php echo $row['id']; ?>" href="#<?php echo $row['nazwa']; ?>"><?php echo $row['nazwa']; ?></a></li>
                <?php } ?>
                </div> 
                <?php }else{?>
                <li><a href="#null">brak kategorii</a></li>
                <?php } ?>
            </ul>
            </li>
            <li <?php if($domID == "0"){ ?> style="display:none"<?php } ?>>
            <a data-toggle="body_produkty" href="#p-<?php echo $domID ?>">Produkty</a>
            <i class='bx bxs-chevron-down produkty-arrow arrow  '></i>
            <ul class="produkty-sub-menu sub-menu">
                <li><a data-toggle="body_produkty" href="#p-<?php echo $domID ?>">Wszystkie produkty</a></li>
                <li><a data-toggle="dodaj_produkt" href="#dp-<?php echo $domID ?>">Dodaj produkt</a></li>
                <li><a data-toggle="historia_produktu" href="#hp-<?php echo $domID ?>">Historia</a></li>
                <?php if($uStatus == "10") { ?><li><a data-toggle="nowy_produkt" href="#np-<?php echo $domID ?>">Nowy produkt</a></li> <?php } ?>
            </ul>
            </li>
            <li <?php if($domID == "0"){ ?> style="display:none"<?php } ?>>
            <a data-toggle="body_lista_zakupow" href="#lz-<?php echo $domID ?>">Zakupy</a>
            <i class='bx bxs-chevron-down js-arrow arrow '></i>
            <ul class="js-sub-menu sub-menu">
              <li><a data-toggle="body_lista_zakupow" href="#lz-<?php echo $domID ?>">Lista zakupów</a></li>
              <li><a data-toggle="body_zakupy" href="#dlz-<?php echo $domID ?>">Dodawanie do listy</a></li>
              <li><a data-toggle="body_historia_zakupow" href="#hlz-<?php echo $domID ?>">Historia zakupów</a></li>
            </ul>
            </li>
            <li>
            <a data-toggle="logout" href="#logout">Wyloguj</a>
            </li>
        </ul>
      </div>
      <div class="search-box">
        <i class='bx bx-search'></i>
        <div class="input-box">
          <input type="text" placeholder="Search...">
        </div>
        </div>
    </div>
  </nav>
<script src="nav/script.js"></script>
<center>
<div id="dane"></div>
<div class="dane" id="dane_body"></div>

</center>
<div id="confirm">
<div class="center">
<div class="body" id="confirm_body">
         <div class="message" id="message"><span>Zamykasz listę zakupów</span> <span> Czy kupiłeś wszystkie produkty?</span></div>
         <button id="tak" class="green">Tak, zamknij listę</button>
         <button id="nie" class="orange">Nie, muszę wprowadzić korekty</button>
         <button id="anuluj" class="red">Anuluj i zamknij</button>
</div>
</div>
</div>
<div id="confirm_z">
<div class="center">
<div class="body" id="confirm_body_z">
         <div id="message_z" class="message"><span>Zaproszenie do spiżarni</span> <span> Czy chcesz dołączyć do tej spiżarni?</span></div>
         <button id="tak_z" class="green">Tak</button>
         <button id="nie_z" class="orange">Nie</button>
         <button id="anuluj_z" class="red">Anuluj</button>
</div>
</div>
</div>
<div id="confirm_z2">
<div class="center">
<div class="body" id="confirm_body_z2">
         <div id="message_z2" class="message"><span>Zapraszanie do spiżarni</span> <span> Nie znaleźliśmy tego maila w naszej bazie. Czy chcesz zaprosić tę osobę do aplikacji?</span></div>
         <button id="tak_z2" class="green">Tak</button>
         <button id="anuluj_z2" class="red">Anuluj</button>
</div>
</div>
</div>
            <div id="myModalSmall" class="modal_small">
                <div id="center_small" class="center_small">
                    <div id= "content_small" class="modal_small-content">
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
<script src="js/home.js"></script>

</body>
</html>