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
<h3>Edycja podstrony <i>regulamin</i></h3>
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



$akcja = $_GET['akcja'];
    if ($akcja == wykonaj) {
	
//poczatek edycji	

$query10="UPDATE podstrony SET 	zawartosc='{$_POST['tresc']}'	WHERE podstrona='1'";

mysql_query($query10) or die(mysql_error()."Błąd!");

	echo "<br><font color=green><b>Podstrona została zaktualizowana.</font><br>";

	
}	

$rekord = @mysql_fetch_array(@mysql_query ("SELECT * FROM podstrony WHERE podstrona = '1'"));
	$tresc=$rekord['zawartosc'];
?>

<form action="admin_edytuj_regulamin.php?akcja=wykonaj" name="form" method="post">


		<textarea type="text" cols="80" rows="11" id="tresc" name="tresc"  value='<?php echo $tresc ?>' /><?php echo $tresc ?></textarea>


		
		<input class="wyslij" type="submit" name="submit" value="Aktualizuj!" />
	</form>			
	
					
					
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
				
				
			
			