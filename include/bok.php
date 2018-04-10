	
				</div>
			</div>
			<!-- end #content -->
			<div id="sidebar">
				<ul>
					
					<li>
						
												
						<?php include('./config.php');
						header('Content-Type: text/html; charset=utf-8'); 
$nick = $_SESSION['nick'];
$haslo = $_SESSION['haslo'];
$user = mysql_fetch_array(mysql_query("SELECT * FROM uzytkownicy WHERE `nick`='$nick' AND `haslo`='$haslo' LIMIT 1"));
$uzytkownik=$user[id];
$plec=$user[plec];
$poziom=$user[uprawnienia];
if ((empty($nick)) OR (empty($haslo)) OR (empty($user[id])) OR !isset($user[id])) {
?>
<h3>Logowanie</h3>
<form method="POST" action="zaloguj.php">
<table cellpadding="0" cellspacing="0" width="180">

<tr><td width="50">Login:</td><td><input type="text" name="login" maxlength="32"></td></tr>
<tr><td width="50">Hasło:</td><td><input type="password" name="haslo" maxlength="32"></td></tr>
<tr><td align="center" colspan="2"><input type="submit" value="Zaloguj"><br></td></tr>
<tr><td align="center" colspan="2"></td></tr>

</table>
</form>
<?
} else {
// tresc dla zalogowanego uzytkownika
echo "<h3>Twój profil</h3><center><h4>Witaj <b><font color='blue'><a href='profil.php?id={$uzytkownik}'>{$user[nick]}</font></b> !<br>"; 
if ($user[avatar]=="0" | $user[avatar]=='')
{
	if ($plec=="Kobieta")
	{ echo "<img src='images/avatar/kobieta.png'/>"; }
	else
	{ echo "<img src='images/avatar/mezczyzna.png'/>"; }
}
else
{
	echo "<img src=\"{$user[avatar]}\"/>";
}

echo "</a></h4></center>";
//Wyswietlanie loginu



?><center>
<?php
if ($poziom==1)
{
echo '<a href="admin.php"><font color="red"><b>Panel administracyjny</b></font></a><br>';
}
else { }
?>
<a href='dodaj.php'><b>Dodaj ogłoszenie</b></a><br>
<a href='moje_ogloszenia.php'>Twoje ogłoszenia</a><br>
<a href='profil.php?id=<?=$uzytkownik?>'>Twój profil</a><br>
<a href='wyloguj.php'>Wyloguj się</a></b>
</center>
<?php
}?>



						
						</p>
					</li>
					<li>
						<h3>Kategorie</h3>
						<div id="Category_box" class="box">
						<ul>
						<?
						$query= "SELECT * FROM `kategorie` ORDER BY `kategorie`.`nazwa` ASC ";
						$result= mysql_query($query);
						while($row=mysql_fetch_array($result)) //pobieranie z bazy
						{
						$identyfikacja=$row["identyfikacja"];
						$nazwa=$row["nazwa"];
																		
									$result2 = mysql_query("SELECT count( * ) FROM ogloszenia, uzytkownicy, kategorie WHERE uzytkownicy.id = ogloszenia.autor AND kategorie.identyfikacja=ogloszenia.kategoria AND ogloszenia.status=1 AND kategorie.identyfikacja='$identyfikacja'");
									$ile=mysql_result($result2, 0);
								
						
						echo "<li><a href='kategoria.php?id={$identyfikacja}'>{$nazwa} ({$ile})</a></li>";
						}
						?>
							
						</ul>
						</div>
					</li>
				</ul>
			</div>
			<!-- end #sidebar -->