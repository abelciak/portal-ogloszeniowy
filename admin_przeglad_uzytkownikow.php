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
<h3>Przegląd użytkowników</h3>
<br>
<center>
<?
if ((empty($nick)) OR (empty($haslo)) OR (empty($user[id])) OR !isset($user[id])) {
echo "Musisz być zalogowany!";
}

else
{
if ($user[uprawnienia]=="1")
{



$admin = $_GET['admin'];
    if ($admin == nadaj) {
		$numer = $_REQUEST['numer'];
		
		$queryNADAJ= "UPDATE uzytkownicy SET uprawnienia=1 WHERE id = {$numer}";
		$resultNADAJ= mysql_query($queryNADAJ);
		echo "<font color=green><b>Prawa administratora zostały nadane.</font><br><br><br>";
						}	
	else if ($admin == odbierz) {
		$numer = $_REQUEST['numer'];
		
		if ($user[id]==$numer)
		{
		echo "<font color=red><b>Nie możesz sobie odebrać uprawnień.</font><br><br><br>";
		}
		else
		{
		$queryODBIERZ= "UPDATE uzytkownicy SET uprawnienia=0 WHERE id = {$numer}";
		$resultODBIERZ= mysql_query($queryODBIERZ);
		echo "<font color=green><b>Prawa administratora zostały odebrane.</font><br><br><br>";
		}
	}
	
	if ($admin == usun) {
		$numer = $_REQUEST['numer'];
		
		if ($user[id]==$numer)
		{
		echo "<font color=red><b>Nie możesz sam siebie usunąć.</font><br><br><br>";
		}
		else
		{
		$queryUSUN= "DELETE FROM uzytkownicy WHERE id = {$numer}";
		$resultUSUN= mysql_query($queryUSUN);
		echo "<font color=green><b>Użytkownik został usunięty.</font><br><br><br>";
		}
	}
	

?>

<table align="center" border="0" style="font-size:14px;border-collapse: collapse; ">
<tr align="center" style="font-size:12px;"><td  width='30'><b>ID</b></td><td><b>Avatar</b></td><td><b>Nick</b></td><td><b>Płeć</b></td><td><b>E-Mail</b></td><td><b>Miasto</b></td><td><b>Logowanie</b></td><td><b>&nbsp;Rejestracja</b></td><td><b>Ogłoszeń&nbsp;</b></td><td><b>Admin</b></td><td><b>Usuń</b></td>
</tr>
<?
$queryPoczatek= "SELECT * FROM uzytkownicy ORDER BY id DESC";
	$resultPoczatek= mysql_query($queryPoczatek);
	while($row=mysql_fetch_array($resultPoczatek)) //pobieranie z bazy
	{
	
	$id=$row["id"];
	$nick=$row["nick"];
	$avatar=$row["avatar"];
	$plec=$row["plec"];
	$email=$row["email"];
	$miejscowosc=$row["miejscowosc"];
	$logowanie=$row["logowanie"];
	$rejestracja=$row["rejestracja"];
	$uprawnienia=$row["uprawnienia"];
	
			$result22 = mysql_query("SELECT count( * ) FROM ogloszenia, uzytkownicy, kategorie WHERE uzytkownicy.id = ogloszenia.autor AND kategorie.identyfikacja=ogloszenia.kategoria AND ogloszenia.status=1 AND ogloszenia.autor=$id ORDER BY `ogloszenia`.`rozpoczecie`");
			$ilosc=mysql_result($result22, 0);
	
	echo "<tr align='center'><td>{$id}</td><td>";
	
	if ($avatar=="0" | $avatar=="")
{
	if ($plec=="Kobieta")
	{ echo "<img width='30' height='30' src='images/avatar/kobieta.png'/>"; }
	else
	{ echo "<img width='30' height='30' src='images/avatar/mezczyzna.png'/>"; }
}
else
{
	echo "<img width='30' height='30' src=\"{$avatar}\"/>";
}
	
	echo"</td><td><a style='font-color:black;' href='profil.php?id={$id}'>{$nick}</a></td><td>";
	
	if ($plec=='Kobieta')
	{ echo "<font color=fuchsia>K</font>";}
	else 
	{ echo "<font color=blue>M</font>";}
	
	
	echo"</td><td>{$email}</td><td>{$miejscowosc}</td><td><sub>{$logowanie}</sub></td><td>&nbsp;<sub>{$rejestracja}</sub></td><td>{$ilosc}</td><td><sub>";
	
	if ($uprawnienia==0)
	{ echo "<font color='red'>NIE</font><br><a href='?admin=nadaj&numer={$id}'>Nadaj</a>"; }
	else
	{ echo "<font color='green'>TAK</font><br><a href='?admin=odbierz&numer={$id}'>Odbierz</a>"; }
	
	echo"</sub></td><td><a href='?admin=usun&numer={$id}'>X</a></td></tr>";
	
	

	}
?>


</table>
	
					
					
<? } 
//koniec edycji

else
{ echo"Nie masz uprawnień!"; } }
?>
				</div>
<?
//KONIEC TREŚĆI!
include 'include/bok.php';
include 'include/stopka.php';
?>
				
				
			
			