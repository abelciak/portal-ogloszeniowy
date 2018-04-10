<title>Portal ogłoszeniowy</title>
<?
include 'include/gora.php';
//START TREŚCI
include("config.php");
?>			
<div id="colA">
					
					
					
<?php
$numer = stripslashes(htmlentities(htmlspecialchars(strip_tags($_GET['id']))));

$result32 = mysql_query("SELECT count( * ) FROM uzytkownicy WHERE uzytkownicy.id = {$numer}");
$check=mysql_result($result32, 0);

	

    if ($check>0) {
	
	$query4= "SELECT * FROM uzytkownicy WHERE uzytkownicy.id = {$numer}";
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
	
	echo "<h3>Profil użytkownika {$nick}</h3><center>";
	
	
	$edytuj = $_GET['edytuj'];
	if ($edytuj == email) {
	
				$numer = $_REQUEST['id'];
				
				if ($user[id]==$numer)
				{
				$rekord = @mysql_fetch_array(@mysql_query ("SELECT * FROM uzytkownicy WHERE id=$numer LIMIT 1"));
				$email=$rekord['email'];
				
				$akcja = $_GET['akcja'];
					if ($akcja==wykonaj)
				{
					
					$queryEDYT="UPDATE uzytkownicy SET email='{$_POST['email']}'WHERE id={$numer}";
					mysql_query($queryEDYT) or die(mysql_error()."Błąd!");
					echo "<font color=green><b>Dane zostały zaktualizowane.</b></font><br><br><br>";
				}
	?>
				<script TYPE="text/javascript" LANGUAGE="JavaScript">
				function check() {
 
				var email =  document.formularz.email.value;
			 
				if (email == '') {
 
				alert('Musisz wypełnić wszystkie pola!');
 
				} else {
 
				document.formularz.submit();
				}
 
				}
				</script> 
	<form action="profil.php?id=<?=$numer?>&edytuj=email&akcja=wykonaj" name="formularz" method="post">
				
				<table>
				<tr><td>Nowy e-mail:</td> <td><input type="text" value='<?php echo $email ?>' name="email" size="45"></td></tr>
				
				
		</table>
				<input type="button" value="Zmień!" onClick="check()">  
				</form><br><br>
	
	<?
	}
	}//koniec email
	
	else if ($edytuj == miejscowosc) {
	
				$numer = $_REQUEST['id'];
				
				if ($user[id]==$numer)
				{
				$rekord = @mysql_fetch_array(@mysql_query ("SELECT * FROM uzytkownicy WHERE id=$numer LIMIT 1"));
				$miejscowosc=$rekord['miejscowosc'];
				
				$akcja = $_GET['akcja'];
					if ($akcja==wykonaj)
				{
					
					$queryEDYT="UPDATE uzytkownicy SET miejscowosc='{$_POST['miejscowosc']}'WHERE id={$numer}";
					mysql_query($queryEDYT) or die(mysql_error()."Błąd!");
					echo "<font color=green><b>Dane zostały zaktualizowane.</b></font><br><br><br>";
				}
	?>
				<script TYPE="text/javascript" LANGUAGE="JavaScript">
				function check() {
 
				var miejscowosc =  document.formularz.miejscowosc.value;
			 
				if (miejscowosc == '') {
 
				alert('Musisz wypełnić wszystkie pola!');
 
				} else {
 
				document.formularz.submit();
				}
 
				}
				</script> 
	<form action="profil.php?id=<?=$numer?>&edytuj=miejscowosc&akcja=wykonaj" name="formularz" method="post">
				
				<table>
				<tr><td>Nowa miejscowość:</td> <td><input type="text" value='<?php echo $miejscowosc ?>' name="miejscowosc" size="45"></td></tr>
				
				
		</table>
				<input type="button" value="Zmień!" onClick="check()">  
				</form><br><br>
	
	<?
	}
	}//koniec miejscowosc
	
	//początek avatar
		
	else if ($edytuj == avatar) {
	
				$numer = $_REQUEST['id'];
				
				if ($user[id]==$numer)
				{
				$rekord = @mysql_fetch_array(@mysql_query ("SELECT * FROM uzytkownicy WHERE id=$numer LIMIT 1"));
				$email=$rekord['email'];
				
				$akcja = $_GET['akcja'];
					if ($akcja==status)
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
					$new_width = 100;
					$new_height = 100;
					$image_p = imagecreatetruecolor($new_width, $new_height);
					$image = imagecreatefromjpeg($filename);
					imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					$galleryPath = 'images/avatar/';
					$generator=md5(mt_rand());
					$zmniejszone=imagejpeg( $image_p, $galleryPath. "{$generator}.jpg", 100 );
					$sciezka='' .$galleryPath. '' .$generator. ".jpg";
					mysql_query("UPDATE uzytkownicy SET avatar='$sciezka' WHERE id=$user[id]");		
					echo '<font color=green><b>Avatar został zaktualizowany!</b></font>';
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
	
	//skrypt poczatek
	?>
	
	<form method="post" action="profil.php?id=<?=$numer?>&edytuj=avatar&akcja=status" enctype="multipart/form-data" name="formularz"> 
	<table><center>
	<tr><td><b>Avatar:</b></td> <td> <input type="file" name="userfile" /></td><td><input type="submit" value="Zmień">  </td></tr>
	<tr><td></td><td>... lub ustaw domyślny. <a href='profil.php?id=<?=$numer?>&edytuj=avatar&akcja=domyslny'>Kliknij tutaj</a></td></tr>

	</table>
		
		</form><br><br>
	
	<?
	//skrypt koniec
	
	}
	}
	
	
	//domyslny
	$akcja = $_GET['akcja'];
		if ($akcja==domyslny)
		{
			if ($user[id]==$numer)
				{
				$queryDOM="UPDATE uzytkownicy SET avatar=0 WHERE id={$numer}";
					mysql_query($queryDOM) or die(mysql_error()."Błąd!");
					echo "<font color=green><b>Avatar został zmieniony na domyślny.</b></font><br><br><br>";
				}
						else {}
		}
	
	//koniec AVATAR
	
	
	
	
	
	if ($poziom==1) 
	{ echo "<sub><font color='red'><b>Administrator</b></font></sub><br>";} else { }
	
	
	if ($avatar=="0" | $avatar=="")
{
	if ($plec=="Kobieta")
	{ echo "<img src='images/avatar/kobieta.png'/>"; }
	else
	{ echo "<img src='images/avatar/mezczyzna.png'/>"; }
}
else
{
	echo "<img src=\"{$avatar}\"/>";
}

//ZMIANA AVATAR
if ($user[id]==$numer)
{ echo "<br><sup> <a href='profil.php?id={$numer}&edytuj=avatar'> Zmień avatar</a></sup>";	} 
else { 	}

//ZMIANA AVATAR KONIEC

	
	echo "<table name='profil'>
<tr><td><b>Nick:</b> {$nick}</td></tr>
<tr><td><b>Płeć:</b> {$plec}</td></tr>
<tr><td><b>Miejscowość:</b> {$miejscowosc}";
if ($user[id]==$numer)
{ echo "<sup> <a href='profil.php?id={$numer}&edytuj=miejscowosc'> Zmień</a></sup>";	} 
else { 	}

echo"</td></tr>
<tr><td><b>E-mail:</b> {$email}";

if ($user[id]==$numer)
{ echo "<sup> <a href='profil.php?id={$numer}&edytuj=email'> Zmień</a></sup>";	} 
else { 	}

echo"</td></tr>
<tr><td><b>Dołączył:</b> {$rejestracja}</td></tr>
<tr><td><b>Ostatnio widziany:</b> {$logowanie}</td></tr>

</table>
<br><br><br>
</centeR>";

$result22 = mysql_query("SELECT count( * ) FROM ogloszenia, uzytkownicy, kategorie WHERE uzytkownicy.id = ogloszenia.autor AND kategorie.identyfikacja=ogloszenia.kategoria AND ogloszenia.status=1 AND ogloszenia.autor=$numer ORDER BY `ogloszenia`.`rozpoczecie`");
$ilosc=mysql_result($result22, 0);

if ($ilosc<1)
echo "<h3><center>Użytkownik nie dodał żadnych ogłoszeń</center></h3>	";
else {
echo "<h3>Ogłoszenia dodane przez użytkownika ({$ilosc}):</h3>	";
?>	
	
	
<dl class="list1">
					<?
					$queryPoczatek= "
SELECT * FROM ogloszenia, uzytkownicy, kategorie WHERE uzytkownicy.id = ogloszenia.autor AND kategorie.identyfikacja=ogloszenia.kategoria AND ogloszenia.status=1 AND ogloszenia.autor=$numer ORDER BY `ogloszenia`.`rozpoczecie` DESC";
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
		echo "<a class='thumbnail' href='ogloszenie.php?id={$ogloszenie}'><img width='41' height='41'  src='images/ogloszenia/brak.png'><span><img src='images/ogloszenia/brak.png' /><br /> <center><b>{$tytul} </b></center> </span></a>";
	}
	else {
		echo "<a class='thumbnail' href='ogloszenie.php?id={$ogloszenie}'><img width='41' height='41'  src='{$zdjecie}'><span><img src='{$zdjecie}' /><br /> <center><b>{$tytul} </b></center> </span></a>"; }
	
echo"</dt><dd><a href='ogloszenie.php?id={$ogloszenie}'><b>{$tytul}</b></a></dd><br>";
	}
	}
	?>
						
					</dl>	
	
	
	
	
<?
	}
						

}	

else

{
?>


<h3>Podany profil nie istnieje!</h3>
<?
}
?>
				</div>
<?

//KONIEC TREŚĆI!
include 'include/bok.php';
include 'include/stopka.php';
?>
				
				
			
			