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
<h3>Przegląd ogłoszeń</h3>
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
//start edycji

	$status = $_GET['status'];
	$admin = $_GET['admin'];
	if ($status == dezaktywuj) {
		$numer = $_REQUEST['numer'];
		
		$queryNADAJ= "UPDATE ogloszenia SET status=0 WHERE ogloszenie = {$numer}";
		$resultNADAJ= mysql_query($queryNADAJ);
		echo "<font color=green><b>Ogłoszenie zostało dezaktywowane.</font><br><br><br>";
						}	
	else if ($status == aktywuj) {
		$numer = $_REQUEST['numer'];
		
		$queryNADAJ= "UPDATE ogloszenia SET status=1 WHERE ogloszenie = {$numer}";
		$resultNADAJ= mysql_query($queryNADAJ);
		echo "<font color=green><b>Ogłoszenie zostało aktywowane.</font><br><br><br>";
						}				

	
	else if ($admin==usun)
	{
		$numer = $_REQUEST['numer'];
		$queryUSUN= "DELETE FROM ogloszenia WHERE ogloszenia.ogloszenie = {$numer}";
		$resultUSUN= mysql_query($queryUSUN);
		echo "<font color=green><b>Ogłoszenie zostało usunięte.</font><br><br><br>";
	}
	else if ($admin==edytuj)
	{
				$numer = $_REQUEST['numer'];
				$rekord = @mysql_fetch_array(@mysql_query ("SELECT * FROM ogloszenia, uzytkownicy, kategorie WHERE ogloszenia.ogloszenie=$numer LIMIT 1"));
				$tytulOGL=$rekord['tytul'];
				$trescOGL=$rekord['tresc'];
				
				$stan = $_GET['stan'];
				if ($stan==edycja)
				{
					
					$queryEDYT="UPDATE ogloszenia SET tresc='{$_POST['trescNEW']}'WHERE ogloszenie={$numer}";
					mysql_query($queryEDYT) or die(mysql_error()."Błąd!");
					$queryEDYT2="UPDATE ogloszenia SET tytul='{$_POST['tytulNEW']}'WHERE ogloszenie={$numer}";
					mysql_query($queryEDYT2) or die(mysql_error()."Błąd!");
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
				<form action="admin_przeglad_ogloszen.php?admin=edytuj&numer=<?=$numer?>&stan=edycja" name="formularz" method="post">
				
				
				<tr><td>Tytuł ogłoszenia:</td> <td><input type="text" value='<?php echo $tytulOGL ?>' name="tytulNEW" size="45"></td></tr>
				<tr><td>Treść: </td> <td><textarea type="text" cols="42" rows="8" id="trescNEW" name="trescNEW"  value='<?php echo $trescOGL ?>' /><?php echo $trescOGL ?></textarea></td></tr>
				
		</table>
				<input type="button" value="Edytuj!" onClick="check()">   <input type="reset" value="Przywróc"/>
				</form>	<br><br></center>
	
	<?
	} // koniec admin edytuj
	
	

	$queryPRZ= "SELECT * FROM ogloszenia, uzytkownicy, kategorie WHERE uzytkownicy.id = ogloszenia.autor AND kategorie.identyfikacja=ogloszenia.kategoria ORDER BY `ogloszenia`.`ogloszenie` DESC ";
	$resultPRZ= mysql_query($queryPRZ);
	?>
	
	<table align="center" border="0" style="font-size:13px;border-collapse: collapse; ">
<tr align="center" style="font-size:12px;"><td><b>ID</b></td><td><b>Foto</b></td><td><b>Tytuł</b></td><td><b>Kategoria</b></td><td><b>Autor</b></td><td><b>Dodane</b></td><td><b>Wygasa</b></td><td><b>Status</b></td><td><b>Zmień</b></td><td><b>&nbsp;Usuń</b></td></tr>
	
	<?
	while($row=mysql_fetch_array($resultPRZ)) //pobieranie z bazy
	{
	
	$nick=$row["nick"];
	$id=$row["id"];
	$ogloszenie=$row["ogloszenie"];
	$plec=$row["plec"];
	$nazwa=$row["nazwa"];
	$zdjecie=$row["zdjecie"];
	$rozpoczecie=$row["rozpoczecie"];
	$zakonczenie=$row["zakonczenie"];
	$tresc=$row["tresc"];
	$status=$row["status"];
	$tytul=$row["tytul"];
	$miejscowosc=$row["miejscowosc"];
	
	echo"<tr align='center'><td>{$ogloszenie}&nbsp;</td><td>";
	
	if ($zdjecie=="0" | $zdjecie=="")
	{
		echo "<a href='ogloszenie.php?id={$ogloszenie}'><img width='30' height='30'  src='images/ogloszenia/brak.png'></a>"; 
	}
	else {
		echo "<a href='ogloszenie.php?id={$ogloszenie}'><img width='30' height='30'  src='{$zdjecie}'></a>"; }
		
	echo "</td><td><sub>{$tytul}</sub></td><td><sub>{$nazwa}</sub></td><td>{$nick}</td><td><sub><sub>{$rozpoczecie}</sub></sub></td><td><sub><sub>{$zakonczenie}</sub></sub></td><td>";
	
	if ($status==1)
	{ echo "<sub><font color=green><b>Aktywny</b></font><br><a href='?status=dezaktywuj&numer={$ogloszenie}'>Dezaktywuj</a></sub>"; }
	else
	{ echo "<sub><font color=red><b>Nieaktywny</b></font><br><a href='?status=aktywuj&numer={$ogloszenie}'>Aktywuj</a></sub>"; }
	
	echo"</td><td><a href='?admin=edytuj&numer={$ogloszenie}'><sub>Edit</sub></a></td><td><a href='?admin=usun&numer={$ogloszenie}'>X</a></td>";	
	
	echo "</tr>";
	}
?>
</table>
<?					
					
} 
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
				
				
			
			