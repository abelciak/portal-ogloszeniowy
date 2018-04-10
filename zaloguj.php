<?php include("config.php"); ?>
<title>Portal ogłoszeniowy</title>
<?
include 'include/gora.php';
//START TREŚCI
?>	
<?php
header('Content-Type: text/html; charset=utf-8'); 
$login = $_POST['login'];
$haslo = $_POST['haslo'];
$haslo = addslashes($haslo);
$login = addslashes($login);
$login = htmlspecialchars($login);

if ($_GET['login'] != '') { //jezeli ktos przez adres probuje kombinowac
exit;
}
if ($_GET['haslo'] != '') { //jezeli ktos przez adres probuje kombinowac
exit;
}

$haslo = md5($haslo); //szyfrowanie hasla
    if (!$login OR empty($login)) {
echo '<center><h3><span style="color: red; ">Wypełnij pole z loginem!</b></span></h3></center>';
include 'include/bok.php';
include 'include/stopka.php';
exit;
}
    if (!$haslo OR empty($haslo)) {
echo '<center><h3><span style="color: red; ">Wypełnij pole z hasłem!</b></span></h3></center>';
include 'include/bok.php';
include 'include/stopka.php';
exit;
}
$istnick = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM `uzytkownicy` WHERE `nick` = '$login' AND `haslo` = '$haslo'")); // sprawdzenie czy istnieje uzytkownik o takim nicku i hasle
    if ($istnick[0] == 0) {
echo '<center><h3><span style="color: red; "><b>Logowanie nieudane. Podałeś zły login lub hasło!</b></span></h3></center>';
    } else {

$_SESSION['nick'] = $login;
$_SESSION['haslo'] = $haslo;
$logowanie=date('Y-m-d H:i:s');
mysql_query("UPDATE uzytkownicy SET uzytkownicy.logowanie ='{$logowanie}'  WHERE uzytkownicy.nick='{$login}'")  or die(mysql_error()."Błąd!");
echo mysql_error();
header("Location: index.php");
}
?>
<?
//KONIEC TREŚĆI!
include 'include/bok.php';
include 'include/stopka.php';
?>
	