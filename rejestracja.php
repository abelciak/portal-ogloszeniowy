<title>Portal ogłoszeniowy</title>
<?
include 'include/gora.php';
//START TREŚCI
//spr czy zalogowany
$nickSPR = $_SESSION['nick'];
$hasloSPR = $_SESSION['haslo'];
$userSPR = mysql_fetch_array(mysql_query("SELECT * FROM uzytkownicy WHERE `nick`='$nick' AND `haslo`='$haslo' LIMIT 1"));
?>			
<div id="colA">
<?
if ((empty($nickSPR)) OR (empty($hasloSPR)) OR (empty($userSPR[id])) OR !isset($userSPR[id])) {
?>
					<h3>Rejestracja</h3>
<center>					

<?php
include("config.php");
 
$uprawnienia=0;
$logowanie=0;
$ip = $_SERVER['REMOTE_ADDR'];
$rejestracja=date('Y-m-d H:i:s');
$plec=$_POST['plec'];

$akcja = $_GET['akcja'];
    if ($akcja == wykonaj) {
//
$nick = substr(addslashes(htmlspecialchars($_POST['nick'])),0,32);
$haslo = substr(addslashes($_POST['haslo']),0,32);
$vhaslo = substr($_POST['vhaslo'],0,32);
$email = substr($_POST['email'],0,32);
$nick = trim($nick);
$miejscowosc = ucwords(trim($_POST["miejscowosc"]));

//kilka sprawdzen co do nicku i maila

$spr1 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM uzytkownicy WHERE nick='$nick' LIMIT 1")); //czy user o takim nicku istnieje
$spr2 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM uzytkownicy WHERE email='$email' LIMIT 1")); // czy user o takim emailu istnieje
$pos = strpos($email, "@");
$pos2 = strpos($email, ".");
$emailx = explode("@", $email);


$komunikaty = '';
$spr4 = strlen($nick);
$spr5 = strlen($haslo);
//sprawdzenie co uzytkownik zle zrobil   
if (!$nick || !$email || !$haslo || !$vhaslo  || !$email    ) {
$komunikaty .= "<span style='color: red; '>Musisz wypełnić wszystkie obowiązkowe pola!<br>"; }
if ($spr4 < 4) {
$komunikaty .= "Login musi mieć przynajmniej 4 znaki<br>"; }
if ($spr5 < 4) {
$komunikaty .= "Hasło musi mieć przynajmniej 4 znaki<br>"; }

if ($spr1[0] >= 1) {
$komunikaty .= "Ten login jest zajęty!<br>"; }
if ($spr2[0] >= 1) {
$komunikaty .= "Ten e-mail jest już używany!<br>"; }

if ($haslo != $vhaslo) {
$komunikaty .= "Hasła się nie zgadzają ...<br>";}
if ($pos == false OR $pos2 == false) {
$komunikaty .= "Nieprawidłowy adres e-mail<br>"; }

//jesli cos jest nie tak to blokuje rejestracje i wyswietla bledy
if ($komunikaty) {
echo '<font color="red"><b>Rejestracja nie powiodła się, popraw następujące błędy:</b></font><br>'.$komunikaty.'<br>';
} else {
//jesli wszystko jest ok dodaje uzytkownika i wyswietla informacje
$nick = str_replace ( ' ','', $nick );
$haslo = md5($haslo); //szyfrowanie hasla

//upload avatara
$dir = 'images/avatar/';
$max_file_size = 3145728; // 3MB
$array_ext = array('jpeg','jpg','png','gif'); // Dozwolone pliki.
$change_name = true; $name_length = 15;

if(!file_exists($dir)) exit('Katalog '.$dir.' nie istnieje!');


    $tmp_name = $_FILES['userfile']['tmp_name'];
    $name = $_FILES['userfile']['name'];
    $type = $_FILES['userfile']['type'];
    $size = $_FILES['userfile']['size'];
    $error = $_FILES['userfile']['error'];
    
    $explode_name = explode('.',$name);
    $extension = @$explode_name[1]; // Rozszerzenie pliku.
    
    if($change_name) {
        $name = $explode_name[0]; // Nazwa pliku.
        $new_name = substr(md5($name),0,$name_length).'.'.$extension; // Nowa nazwa dla pliku, czyli zahashowanie nazwy i skrócenia jej do danej długości i dodanie rozszerzenia pliku.
        $path = $dir.$new_name; // [katalog]/[nazwa_pliku].[roz]
    }
    else {
        $path = $dir.$name;
    }
    
    $dirname = dirname($_SERVER['SCRIPT_NAME']) == '/' || dirname($_SERVER['SCRIPT_NAME']) == '\\' ? null : dirname($_SERVER['SCRIPT_NAME']);
    
    $full_path = 'http://'.$_SERVER['HTTP_HOST'].$dirname.'/'.$path; // Pełna ścieżka do pliku.
    
    if($error == UPLOAD_ERR_NO_FILE) {
        echo '';
    }
    elseif($error == UPLOAD_ERR_PARTIAL) {
        echo 'Błąd! Plik został tylko częściowo załadowany.';
    }
    elseif($error == UPLOAD_ERR_NO_TMP_DIR) {
        echo 'Błąd! Brak folderu tymczasowego.';
    }
    elseif($error == UPLOAD_ERR_INI_SIZE) {
        echo 'Błąd! Plik jest za duży dla serwera.';
    }
    elseif(!in_array($extension,$array_ext)) {
        echo 'Niedozwolony plik.';
    }
    elseif($size > $max_file_size) {
        echo 'Za duży plik.';
    }
    else {
    
        if(is_uploaded_file($tmp_name)) {
        
            if(move_uploaded_file($tmp_name,$path)) {
              
				
					$filename = $path;
					list($width, $height) = getimagesize($filename);
					$new_width = 100;
					$new_height = 100;
					$image_p = imagecreatetruecolor($new_width, $new_height);
					$image = imagecreatefromjpeg($filename);
					imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					$galleryPath = 'images/avatar/';
					$generator=md5(mt_rand());
					$zmniejszone=imagejpeg( $image_p, $galleryPath. "{$generator}.jpg", 100 );
					$sciezka='' .$galleryPath. '' .$generator. ".jpg";
					 		
				
            }
            else {
                echo 'Nie udało się wysłać pliku. Spróbuj później.';
            }
       
        }
        else {
            echo 'Błąd!.';
        }
    
    }
        

//koniec uploadu


mysql_query("INSERT INTO `uzytkownicy` (nick, haslo, email, miejscowosc, rejestracja, logowanie, uprawnienia, avatar,plec) VALUES('$nick', '$haslo','$email','$miejscowosc', '$rejestracja','$logowanie','$uprawnienia','$sciezka','$plec')")  or die(mysql_error()."Błąd!");


echo '<br><span style="color: green; font-weight: bold;">'.$nick.', właśnie zostałeś/aś zarejestrowany na naszym portalu. Teraz możesz się już zalogować!</span><br><br>';
}
}
?>

<script TYPE="text/javascript" LANGUAGE="JavaScript">
 function check() {
 
var nick =  document.formularz.nick.value;
var haslo =  document.formularz.haslo.value;
var vhaslo =  document.formularz.vhaslo.value;
var email =  document.formularz.email.value;
var miejscowosc =  document.formularz.miejscowosc.value;
 
if (nick = '' || haslo == '' || vhaslo == '' || email == '' || miejscowosc == '') {
 
         alert('Musisz wypełnić wszystkie pola!');
 
     } else {
 
            document.formularz.submit();
          }
 
}
</script> 
<form method="post" action="rejestracja.php?akcja=wykonaj" enctype="multipart/form-data" name="formularz"> 
 <table><center>
<tr><td><b>Podaj nick:</b></td> <td><input type="text" name="nick" value="<?=$nick?>"></td></tr>
<tr><td><b>Podaj hasło:</b> </td> <td><input type="password" name="haslo" value="<?=$haslo?>"></td></tr>
<tr><td><b>Powtórz hasło:</b> </td> <td><input type="password" name="vhaslo" value="<?=$vhaslo?>"></td></tr>
<tr><td><b>Podaj e-mail:</b> </td> <td><input type="text" name="email" value="<?=$email?>"></td></tr>
<tr><td><b>Podaj miejscowość:</b></td> <td> <input type="text" name="miejscowosc" value="<?=$miejscowosc?>" ></td></tr>
<tr><td><b>Wybierz płeć:</b></td> <td> <select name="plec" style="width: 142">
		<option value='Mężczyzna'>Mężczyzna</option>
		<option value='Kobieta'>Kobieta</option></select></td></tr> 
<tr><td><b>Avatar:</b></td> <td> <input type="file" name="userfile" /></td></tr>
		
		
		</center></table>
<input type="button" value="Zarejestruj!" onClick="check()">   <input type="reset" value="Wyczyść"/> </form>
				
<?
}
else
{
echo "<b>Nie możesz się zarejestrować, ponieważ jesteś zalogowany :)</b>";
}
?>				
				</div>
<?
//KONIEC TREŚĆI!
include 'include/bok.php';
include 'include/stopka.php';
?>
				
				
			
			