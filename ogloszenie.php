<title>Portal ogłoszeniowy</title>
<?
include 'include/gora.php';
//START TREŚCI
include("config.php");
?>			
<div id="colA">
					
					
					
<?php
$numer = stripslashes(htmlentities(htmlspecialchars(strip_tags($_GET['id']))));

$result32 = mysql_query("SELECT count( * ) FROM ogloszenia, uzytkownicy, kategorie WHERE uzytkownicy.id = ogloszenia.autor AND kategorie.identyfikacja=ogloszenia.kategoria AND ogloszenia.ogloszenie = {$numer} AND ogloszenia.status=1");
$check=mysql_result($result32, 0);

    if ($check>0) {
	
	$query= "SELECT * FROM ogloszenia, uzytkownicy, kategorie WHERE uzytkownicy.id = ogloszenia.autor AND kategorie.identyfikacja=ogloszenia.kategoria AND ogloszenia.ogloszenie = {$numer} AND ogloszenia.status=1";
	$result= mysql_query($query);
	while($row=mysql_fetch_array($result)) //pobieranie z bazy
	{
	
	$nick=$row["nick"];
	$id=$row["id"];
	$plec=$row["plec"];
	$nazwa=$row["nazwa"];
	$zdjecie=$row["zdjecie"];
	$rozpoczecie=$row["rozpoczecie"];
	$zakonczenie=$row["zakonczenie"];
	$tresc=$row["tresc"];
	$tytul=$row["tytul"];
	$miejscowosc=$row["miejscowosc"];
	echo "<h3>{$tytul} [{$nazwa}]</h3><center>
	<table name='ogloszenia'>
<tr><td><b>Data dodania:</b> {$rozpoczecie}</td><td width='80'></td><td><b>Wygasa:</b> {$zakonczenie}</td></tr>
<tr><td>";

if ($plec=='Kobieta')
{ echo "<b>Dodała:</b>"; }
else
{ echo "<b>Dodał:</b>"; }

echo "<a href='profil.php?id={$id}'> {$nick}</a></td> <td width='80'></td><td><b>Miejscowość:</b> {$miejscowosc}</td></tr>";

if ($zdjecie=="0" | $zdjecie=="")
{
}
else 
{
echo "<tr><td colspan='3' align='center'><br><img src='{$zdjecie}'/></td></tr>";
}

echo "</table>
<br><br>
{$tresc}
	
	";
	}
						

}	

else

{
?>


<h3>Podane ogłoszenie nie istnieje!</h3>
<?
}
?>
				</div>
<?

//KONIEC TREŚĆI!
include 'include/bok.php';
include 'include/stopka.php';
?>
				
				
			
			