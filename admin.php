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
<?
if ((empty($nick)) OR (empty($haslo)) OR (empty($user[id])) OR !isset($user[id])) {
echo "Musisz być zalogowany!";
}

else
{
if ($user[uprawnienia]=="1")
{?>

<h3>Panel administratora</h3>
<br>
<center>
<h3>Kategorie</h3>
<b><a href ="admin_dodaj_kategorie.php">Dodaj kategorie ogłoszeń</a><br>
<a href ="admin_usun_kategorie.php">Usuń kategorie ogłoszeń</a><br>
<a href ="admin_nazwy_kategorie.php">Zmień nazwy kategorii ogłoszeń</a><br>
<br><br><h3>Ogłoszenia</h3>
<a href ="admin_przeglad_ogloszen.php">Przegląd ogłoszeń</a><br> 
<br><br><h3>Podstrony</h3>
<a href ="admin_edytuj_regulamin.php">Edytuj <i>Regulamin</i></a><br>
<a href ="admin_edytuj_kontakt.php">Edytuj <i>Kontakt</i></a> <br>
<br><br><h3>Użytkownicy</h3>
<a href ="admin_przeglad_uzytkownikow.php">Przegląd użytkowników</a><br> </b>



</center>
					
					
<? } 

else
{ echo"Nie masz uprawnień!"; } }
?>
				</div>
<?
//KONIEC TREŚĆI!
include 'include/bok.php';
include 'include/stopka.php';
?>
				
				
			
			