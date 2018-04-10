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
<h3>Zmień nazwę kategorii</h3>
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
$identyfikator=$_POST["kategoria"];	
$nowa=$_POST["nowa"];	

$query10="UPDATE `kategorie`  SET nazwa='{$nowa}' WHERE `kategorie`.`identyfikacja` = '{$identyfikator}'";

mysql_query($query10) or die(mysql_error()."Błąd!");

	echo "<br><font color=green><b>Kategoria została zmieniona.</font><br>";

	
}	

?>

<form method="post" action="admin_nazwy_kategorie.php?akcja=wykonaj" name="formularz"> 
 <table><center>
 <tr><td>Kategoria:</td> <td> <select name="kategoria">
<?
						$query= "SELECT * FROM `kategorie` ORDER BY `kategorie`.`nazwa` ASC ";
						$result= mysql_query($query);
						while($row=mysql_fetch_array($result)) //pobieranie z bazy
						{
						$identyfikacja=$row["identyfikacja"];
						$nazwa=$row["nazwa"];
																	
						echo "<option value='{$identyfikacja}'>{$nazwa}</option>";
						}
						?>
		 </select></td></tr> 
	<tr><td>Nowa nazwa:</td> <td><input type="text" name="nowa" size="45"></td></tr>	 
		</table>
<input type="submit" value="Zmień!">   </form>			
	
					
					
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
				
				
			
			