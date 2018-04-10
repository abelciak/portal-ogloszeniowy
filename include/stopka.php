<div style="clear: both;">&nbsp;</div>
			<div id="widebar">
				<div id="colA">
					<h3>Losowe ogłoszenia:</h3>
					<dl class="list1">
						
						
						<?
					$query= "SELECT * FROM ogloszenia, uzytkownicy, kategorie WHERE uzytkownicy.id = ogloszenia.autor AND kategorie.identyfikacja=ogloszenia.kategoria AND ogloszenia.status=1 ORDER BY rand(), `ogloszenia`.`rozpoczecie` LIMIT 5";
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
	echo "<dt>{$rozpoczecie}</dt><dt><a href='ogloszenie.php?id={$ogloszenie}'>";
	
	if ($zdjecie=="0" | $zdjecie=="")
	{
		echo "<img width='41' height='41'  src='images/ogloszenia/brak.png'>";
		
	}
	else {
		echo "<img width='41' height='41'  src='{$zdjecie}'>"; }
	
echo"</dt><dd><b>{$tytul}</b></a></dd><br>";
	
	}
	?>	
					</dl>
				</div>
				
				<div id="colB">
					<h3> </h3>
					
				</div>
				
				<div id="colC">
					<h3>Ostatnio zarejestrowani:</h3>
					<ul class="list2">
						
						<?
						$licznik=1;
						
						$query= "SELECT * FROM `uzytkownicy` ORDER BY `uzytkownicy`.`rejestracja` DESC LIMIT 9";
						$result= mysql_query($query);
						while($row=mysql_fetch_array($result)) //pobieranie z bazy
						{
	
						$nick=$row["nick"];
						$plec=$row["plec"];
						$id=$row["id"];
						$avatar=$row["avatar"];
						
						if ($licznik=="3" OR $licznik=="6" OR $licznik=="9")
						{
						echo "<li class='nopad'><a href='profil.php?id={$id}'>";
						}
						else
						{
						echo "<li><a href='profil.php?id={$id}'>";
						}
					
						if ($avatar=="0" | $avatar=="")
						{
							if ($plec=="Kobieta")
							{ echo "<img width='50' height='50' title='Użytkownik: {$nick}' src='images/avatar/kobieta.png'/>"; }
							else
							{ echo "<img width='50' height='50' title='Użytkownik: {$nick}' src='images/avatar/mezczyzna.png'/>"; }
						}
						else
						{
						echo "<img src='{$avatar}' title='Użytkownik: {$nick}' width='50' height='50'/>";
						}
	
						echo "</a></li>"; 
						
						$licznik++;
						}
						?>
					
						
						
					</ul>
				</div>
				<div style="clear: both;">&nbsp;</div>
			</div>
			<!-- end #widebar -->
		</div>
		<!-- end #page -->
	</div>
	<!-- end #wrapper2 -->
	<div id="footer">
		<p></p>
	</div>
</div>
<!-- end #wrapper -->
</body>
</html>
