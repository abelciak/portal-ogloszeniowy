<title>Portal ogłoszeniowy</title>
<?
include 'include/gora.php';
//START TREŚCI
include("config.php");
?>			
<div id="colA">
					
					
					
<?php
$numer = stripslashes(htmlentities(htmlspecialchars(strip_tags($_GET['id']))));

$result32 = mysql_query("SELECT count( * ) FROM kategorie WHERE kategorie.identyfikacja='$numer'");
$check=mysql_result($result32, 0);

    if ($check>0) {
	
						$query3= "SELECT * FROM kategorie WHERE kategorie.identyfikacja='$numer'";
						$result3= mysql_query($query3);
						while($row=mysql_fetch_array($result3)) //pobieranie z bazy
						{
						$wybor=$row["nazwa"];
																		
																	
						echo "<h3>Ogłoszenia w kategorii: {$wybor}</h3>";
						}
	
	
	echo "<dl class='list1'>";
	$query= "SELECT * FROM ogloszenia, uzytkownicy, kategorie WHERE uzytkownicy.id = ogloszenia.autor AND kategorie.identyfikacja=ogloszenia.kategoria AND ogloszenia.status=1 AND ogloszenia.kategoria={$numer} ORDER BY `ogloszenia`.`rozpoczecie` DESC";
	
	$result= mysql_query($query);
	while($row=mysql_fetch_array($result)) //pobieranie z bazy
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
	echo "</dl>";
						

}	

else

{
?>


<h3>Podana kategoria ogłoszeń nie istnieje!</h3>
<?
}
?>
				</div>
<?

//KONIEC TREŚĆI!
include 'include/bok.php';
include 'include/stopka.php';
?>
				
				
			
			