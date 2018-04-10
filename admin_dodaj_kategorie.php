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

<script TYPE="text/javascript" LANGUAGE="JavaScript">
 function check() {
 
var nazwa =  document.formularz.nazwa.value;
 
if (nazwa == '') {
 
         alert('Musisz wypełnić wszystkie pola!');
 
     } else {
 
            document.formularz.submit();
          }
 
}
</script> 
<div id="colA">
<h3>Dodawanie kategorii</h3>
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
	
$nazwa=$_POST["nazwa"];



$query="INSERT INTO kategorie (nazwa) 
VALUES('{$nazwa}')";

mysql_query($query) or die(mysql_error()."Błąd!");

	echo "<br><font color=green><b>Kategoria dodana prawidłowo.</font><br><br><br><br></p>";
	
}	

?>


<form method="post" action="admin_dodaj_kategorie.php?akcja=wykonaj" name="formularz"> 
<table><center>
<tr><td>Nazwa kategori:</td> <td><input type="text" name="nazwa" size="45"></td></tr>
</center></table>

<input type="button" value="Dodaj kategorie!" onClick="check()">   <input type="reset" value="Wyczyść"/> </form>				
</center>			
					
					
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
				
				
			
			