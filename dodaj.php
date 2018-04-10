<title>Portal ogłoszeniowy</title>
<?
include 'include/gora.php';
//START TREŚCI
include("config.php");
//spr czy zalogowany
$nick = $_SESSION['nick'];
$haslo = $_SESSION['haslo'];
$user = mysql_fetch_array(mysql_query("SELECT * FROM uzytkownicy WHERE `nick`='$nick' AND `haslo`='$haslo' LIMIT 1"));
?>			
<div id="colA">
					<h3>Dodaj ogłoszenie!</h3>
					
<center>					
<?php
if ((empty($nick)) OR (empty($haslo)) OR (empty($user[id])) OR !isset($user[id])) {

echo "<b>Musisz być zalogowany by dodać ogłoszenie!</b>";
}
else
{

$akcja = $_GET['akcja'];
    if ($akcja == wykonaj) {
	
$tytul=htmlspecialchars(strip_tags(mysql_real_escape_string($_POST["tytul"])));
$tresc=htmlspecialchars(strip_tags(mysql_real_escape_string($_POST["tresc"])));
$kategoria=$_POST["kategoria"];
$czas=$_POST["czas"];
$autor=$user[id];
$rozpoczecie=date('Y-m-d H:i:s');
$zakonczenie=date('Y-m-d H:i:s', time()+($czas*60*60*24));
$status=1;


//upload ogloszenia
$dir = 'images/ogloszenia/';
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
        echo 'Twoje zdjęcie nie zostało wgrane.';
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
					$new_width = 300;
					$new_height = 300;
					$image_p = imagecreatetruecolor($new_width, $new_height);
					$image = imagecreatefromjpeg($filename);
					imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					$galleryPath = 'images/ogloszenia/';
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

$query="INSERT INTO ogloszenia(autor, kategoria, rozpoczecie, zakonczenie, tytul, tresc, status, zdjecie) 
VALUES('{$autor}','{$kategoria}','{$rozpoczecie}','{$zakonczenie}','{$tytul}','{$tresc}','{$status}','{$sciezka}' )";

mysql_query($query) or die(mysql_error()."Błąd!");

	echo "<br><font color=green><b>Ogłoszenie zostało dodane prawidłowo.</font><br><font color=blue>Będzie wyświetlane do dnia {$zakonczenie}</b></font><br><br><br></p>";
	



	
	
}	

?>

<script TYPE="text/javascript" LANGUAGE="JavaScript">
 function check() {
 
var tytul =  document.formularz.tytul.value;
var tresc =  document.formularz.tresc.value;
 
if (tytul == '' || tresc == '') {
 
         alert('Musisz wypełnić wszystkie pola!');
 
     } else {
 
            document.formularz.submit();
          }
 
}
</script> 

<form method="post" action="dodaj.php?akcja=wykonaj" name="formularz" enctype="multipart/form-data"> 
 <table><center>
<tr><td>Tytuł ogłoszenia:</td> <td><input type="text" name="tytul" size="45"></td></tr>
<tr><td>Treść: </td> <td><textarea type="text" cols="42" rows="5" id="tresc" name="tresc"></textarea></td></tr>
<tr><td>Kategoria:</td> <td> <select name="kategoria">
<?
						$query= "SELECT * FROM `kategorie`";
						$result= mysql_query($query);
						while($row=mysql_fetch_array($result)) //pobieranie z bazy
						{
						$identyfikacja=$row["identyfikacja"];
						$nazwa=$row["nazwa"];
						echo "<option value='{$identyfikacja}'>{$nazwa}</option>";
						}
						?>
		 </select></td></tr> 
		
<tr><td>Czas trwania ogłoszenia: </td> <td><select name="czas">
		<option value='3'>3 dni</option>
		<option value='7'>7 dni</option>
		<option value='14'>14 dni</option> 
		<option value='21'>21 dni</option> 
		<option value='28'>28 dni</option> 
		</select></td></tr> 
<tr><td>Zdjęcie:</td> <td> <input type="file" name="userfile" /></td></tr>

		
		</center></table>
<input type="button" value="Dodaj ogłoszenie!" onClick="check()">   <input type="reset" value="Wyczyść"/> </form>			
</center>					
				
<?
}
echo "</div>";




//KONIEC TREŚĆI!
include 'include/bok.php';
include 'include/stopka.php';
?>
				
				
			
			