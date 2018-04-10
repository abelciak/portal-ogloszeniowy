<title>Portal ogłoszeniowy</title>
<?
include 'include/gora.php';
//START TREŚCI
?>			
<div id="colA">
					<h3>Ostatnio dodane ogłoszenia:</h3>
					<dl class="list1">
					<?
					$queryPoczatek= "SELECT * FROM ogloszenia, uzytkownicy, kategorie WHERE uzytkownicy.id = ogloszenia.autor AND kategorie.identyfikacja=ogloszenia.kategoria AND ogloszenia.status=1 ORDER BY `ogloszenia`.`rozpoczecie` DESC LIMIT 7";
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
	?>
						
					</dl>
				</div>
				<br><br>
				
				
				<div id="colB">
					<h3>Najszybciej kończące się:</h3>
					<dl class="list1">
						<?
					$queryKoniec= "SELECT * FROM ogloszenia, uzytkownicy, kategorie WHERE uzytkownicy.id = ogloszenia.autor AND kategorie.identyfikacja=ogloszenia.kategoria AND ogloszenia.status=1 ORDER BY `ogloszenia`.`zakonczenie` ASC LIMIT 7";
	$resultKoniec= mysql_query($queryKoniec);
	while($row=mysql_fetch_array($resultKoniec)) //pobieranie z bazy
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
	echo "<dt>{$zakonczenie}</dt><dt>";
	
	if ($zdjecie=="0" | $zdjecie=="")
	{
		echo "<a class='thumbnail' href='ogloszenie.php?id={$ogloszenie}'><img width='41' height='41'  src='images/ogloszenia/brak.png'><span><img src='images/ogloszenia/brak.png' /><br /> <center><b>{$tytul} </b></center> </span></a>";
	}
	else {
		echo "<a class='thumbnail' href='ogloszenie.php?id={$ogloszenie}'><img width='41' height='41'  src='{$zdjecie}'><span><img src='{$zdjecie}' /><br /> <center><b>{$tytul} </b></center> </span></a>"; }
	
echo"</dt><dd><a href='ogloszenie.php?id={$ogloszenie}'><b>{$tytul}</b></a></dd><br>";
	
	}
	?>
					</dl>
				</div>
<?
//KONIEC TREŚĆI!
include 'include/bok.php';
include 'include/stopka.php';
?>
				
				
			
			