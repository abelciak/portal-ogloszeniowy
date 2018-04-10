<title>Portal ogłoszeniowy</title>
<?
include 'include/gora.php';
//START TREŚCI
include("config.php");
?>			
<div id="colA">
					
					
					
<?php



if ((empty($nick)) OR (empty($haslo)) OR (empty($user[id])) OR !isset($user[id])) {

echo "<h3>Musisz być zalogowany by przeglądać swoje ogłoszenia!</h3>";
}
else
{

	$akcja = $_GET['akcja'];
	
    if ($akcja == usun) {
	
	$numer = $_REQUEST['numer'];
	
	$sprawdzenie = mysql_fetch_array(mysql_query("SELECT ogloszenia.autor FROM ogloszenia, uzytkownicy, kategorie WHERE ogloszenia.ogloszenie=$numer LIMIT 1"));
		
	$checker=$sprawdzenie[autor];
	if ($checker==$user[id])
	{ 
		$queryUSUN= "DELETE FROM ogloszenia WHERE ogloszenia.ogloszenie = {$numer}";
		$resultUSUN= mysql_query($queryUSUN);
		echo "<font color=green><b>Ogłoszenie zostało usunięte.</font><br><br><br>";
	}
	else { echo "<b><font color=red>Nie możesz usunąć nieswojego ogłoszenia</font></b><br><br><br>";}
	
	}
	
	
	else if ($akcja == zdjecie) {
	
	$numer = $_REQUEST['numer'];
	
	$sprawdzenie = mysql_fetch_array(mysql_query("SELECT ogloszenia.autor FROM ogloszenia, uzytkownicy, kategorie WHERE ogloszenia.ogloszenie=$numer LIMIT 1"));
		
	$checker=$sprawdzenie[autor];
	if ($checker==$user[id])
	{ 
	
			$przeslij = $_GET['przeslij'];
					if ($przeslij==zdjecie)
				{
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
        echo 'Nie wybrałeś pliku!';
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
					mysql_query("UPDATE ogloszenia SET zdjecie='$sciezka' WHERE ogloszenie=$numer");		
					echo '<font color=green><b>Zdjęcie zostało zaktualizowane!</b></font>';
            }
            else {
                echo 'Nie udało się wysłać pliku. Spróbuj później.';
            }
       
        }
        else {
            echo 'Błąd!.';
        }
    
    }
					
					
				}
				
				else if ($przeslij==domyslny)
		{
			$sprawdzenie = mysql_fetch_array(mysql_query("SELECT ogloszenia.autor FROM ogloszenia, uzytkownicy, kategorie WHERE ogloszenia.ogloszenie=$numer LIMIT 1"));
		
	$checker=$sprawdzenie[autor];
	if ($checker==$user[id])
				{
				$queryDOM="UPDATE ogloszenia SET zdjecie=0 WHERE ogloszenie={$numer}";
					mysql_query($queryDOM) or die(mysql_error()."Błąd!");
					echo "<font color=green><b>Zdjecie zostało zmienione na domyślne.</b></font><br><br><br>";
				}
						else {}
		}
			
			?><center>
			<form method="post" action="moje_ogloszenia.php?akcja=zdjecie&numer=<?=$numer?>&przeslij=zdjecie" enctype="multipart/form-data" name="formularz"> 
			<table><center>
			<tr><td><b>Zdjęcie:</b></td> <td> <input type="file" name="userfile" /></td><td><input type="submit" value="Zmień">  </td></tr>
			<tr><td></td><td>... lub ustaw domyślne. <a href='moje_ogloszenia.php?akcja=zdjecie&numer=<?=$numer?>&przeslij=domyslny'>Kliknij tutaj</a></td></tr>
			</table>
			</form><br><br></center>
			<?
	}
	else { echo "<b><font color=red>Nie możesz edytować nieswojego ogłoszenia</font></b><br><br><br>";}
	
	}
	
	
	
	
	else if($akcja == edytuj)
	{
	
			$numer = $_REQUEST['numer'];
			
						$sprawdzenie = mysql_fetch_array(mysql_query("SELECT ogloszenia.autor FROM ogloszenia, uzytkownicy, kategorie WHERE ogloszenia.ogloszenie=$numer LIMIT 1"));
		
			$checker=$sprawdzenie[autor];
			if ($checker==$user[id])
			{ 
				$rekord = @mysql_fetch_array(@mysql_query ("SELECT * FROM ogloszenia, uzytkownicy, kategorie WHERE uzytkownicy.id = ogloszenia.autor AND kategorie.identyfikacja=ogloszenia.kategoria AND ogloszenia.ogloszenie=$numer LIMIT 1"));
				$tytulOGL=$rekord['tytul'];
				$trescOGL=$rekord['tresc'];
				$nazwaOGL=$rekord['nazwa'];
				
				$status = $_GET['status'];
				
				if ($status==edycja)
				{
					
					$queryEDYT="UPDATE ogloszenia SET tresc='{$_POST['trescNEW']}'WHERE ogloszenie={$numer}";
					mysql_query($queryEDYT) or die(mysql_error()."Błąd!");
					$queryEDYT2="UPDATE ogloszenia SET tytul='{$_POST['tytulNEW']}'WHERE ogloszenie={$numer}";
					mysql_query($queryEDYT2) or die(mysql_error()."Błąd!");
					$queryEDYT3="UPDATE ogloszenia SET kategoria='{$_POST['kategoriaNEW']}'WHERE ogloszenie={$numer}";
					mysql_query($queryEDYT3) or die(mysql_error()."Błąd!");
					echo "<font color=green><b>Ogłoszenie zostało zaktualizowane.</b></font><br><br><br>";
				}
				
				
				?>
				
				<script TYPE="text/javascript" LANGUAGE="JavaScript">
				function check() {
 
				var tytulNEW =  document.formularz.tytulNEW.value;
				var trescNEW =  document.formularz.trescNEW.value;
 
				if (tytulNEW == '' || trescNEW == '') {
 
				alert('Musisz wypełnić wszystkie pola!');
 
				} else {
 
				document.formularz.submit();
				}
 
				}
				</script> 
				
				<center><table>
				<form action="moje_ogloszenia.php?akcja=edytuj&numer=<?=$numer?>&status=edycja" name="formularz" method="post">
				
				
				<tr><td>Tytuł ogłoszenia:</td> <td><input type="text" value='<?php echo $tytulOGL ?>' name="tytulNEW" size="45"></td></tr>
				<tr><td>Treść: </td> <td><textarea type="text" cols="42" rows="8" id="trescNEW" name="trescNEW"  value='<?php echo $trescOGL ?>' /><?php echo $trescOGL ?></textarea></td></tr>
				<tr><td>Kategoria:</td> <td> <select name="kategoriaNEW">
<?
						$queryKAT= "SELECT * FROM `kategorie`";
						$resultKAT= mysql_query($queryKAT);
						while($row=mysql_fetch_array($resultKAT)) //pobieranie z bazy
						{
						$identyfikacjaKAT=$row["identyfikacja"];
						$nazwaKAT=$row["nazwa"];
						
						if ($nazwaKAT==$nazwaOGL)
						{	echo "<option selected='selected' value='{$identyfikacjaKAT}'>{$nazwaKAT}</option>"; }
						else
						{	echo "<option value='{$identyfikacjaKAT}'>{$nazwaKAT}</option>"; }
						
						}
						?>
		 </select></td></tr> 
				
		</table>
				<input type="button" value="Edytuj!" onClick="check()">   <input type="reset" value="Przywróc"/>
				</form>	<br><br></center>
				
				<?
			}
			else { echo "<b><font color=red>Nie możesz edytować nieswojego ogłoszenia</font></b><br><br><br>";}
	
	}
	
	$query4= "SELECT * FROM uzytkownicy WHERE uzytkownicy.id = {$user[id]}";
	$result4= mysql_query($query4);
	while($row=mysql_fetch_array($result4)) //pobieranie z bazy
	{
	
	$nick=$row["nick"];
	$plec=$row["plec"];
	$avatar=$row["avatar"];
	$email=$row["email"];
	$poziom=$row["uprawnienia"];
	$miejscowosc=$row["miejscowosc"];
	$rejestracja=$row["rejestracja"];
	$logowanie=$row["logowanie"];
	
	
	
echo "</centeR>";

$result22 = mysql_query("SELECT count( * ) FROM ogloszenia, uzytkownicy, kategorie WHERE uzytkownicy.id = ogloszenia.autor AND kategorie.identyfikacja=ogloszenia.kategoria AND ogloszenia.status=1 AND ogloszenia.autor=$user[id] ORDER BY `ogloszenia`.`rozpoczecie`");
$ilosc=mysql_result($result22, 0);

if ($ilosc<1)
echo "<h3>Brak dodanych ogłoszeń</h3>	";
else {

echo "<h3>Moje ogłoszenia ({$ilosc}):</h3>";
?>	
	
	
<dl class="list1">
					<?
					
					$queryPoczatek= "
SELECT * FROM ogloszenia, uzytkownicy, kategorie WHERE uzytkownicy.id = ogloszenia.autor AND kategorie.identyfikacja=ogloszenia.kategoria AND ogloszenia.status=1 AND ogloszenia.autor=$user[id] ORDER BY `ogloszenia`.`rozpoczecie` DESC";
	$resultPoczatek= mysql_query($queryPoczatek);
	while($row=mysql_fetch_array($resultPoczatek)) //pobieranie z bazy
	{
	
	$nick=$row["nick"];
	$avatar=$row["avatar"];
	$zdjecie=$row["zdjecie"];
	$ogloszenie=$row["ogloszenie"];
	$nazwa=$row["nazwa"];
	$rozpoczecie=$row["rozpoczecie"];
	$zakonczenie=$row["zakonczenie"];
	$tresc=$row["tresc"];
	$tytul=$row["tytul"];
	$miejscowosc=$row["miejscowosc"];
	echo "<dt>{$rozpoczecie}</dt><dt>";
	
	if ($zdjecie=="0" | $zdjecie=="")
	{
		echo "<a class='thumbnail' href='ogloszenie.php?id={$ogloszenie}'><img width='51' height='51'  src='images/ogloszenia/brak.png'><span><img src='images/ogloszenia/brak.png' /><br /> <center><b>{$tytul} </b></center> </span></a>";
	}
	else {
		echo "<a class='thumbnail' href='ogloszenie.php?id={$ogloszenie}'><img width='51' height='51'  src='{$zdjecie}'><span><img src='{$zdjecie}' /><br /> <center><b>{$tytul} </b></center> </span></a>"; }
	
echo"</dt><dd><a href='ogloszenie.php?id={$ogloszenie}'><b>{$tytul}</b></a></dd><dd><a href='?akcja=zdjecie&numer={$ogloszenie}'>Zmień zdjęcie</a> || <a href='?akcja=edytuj&numer={$ogloszenie}'>Edytuj</a> || <a href='?akcja=usun&numer={$ogloszenie}'>Usuń</a> </dd><br>";
	}
	}
	?>
						
					</dl>	
	
	
	
	
<?
	}
						

}	


?>
				</div>
<?

//KONIEC TREŚĆI!
include 'include/bok.php';
include 'include/stopka.php';
?>
				
				
			
			