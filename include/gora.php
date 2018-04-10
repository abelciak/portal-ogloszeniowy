<?php 
header('Content-Type: text/html; charset=utf-8');
//session_cache_limiter('private');
session_cache_limiter("must-revalidate");
include('./config.php');
$nick = $_SESSION['nick'];
$haslo = $_SESSION['haslo'];
$user = mysql_fetch_array(mysql_query("SELECT * FROM uzytkownicy WHERE `nick`='$nick' AND `haslo`='$haslo' LIMIT 1"));

?>
<html>
<head>
<meta charset="utf-8" />
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<div id="wrapper">
	<div id="wrapper2">
		<div id="header">
			<div id="logo">
				<a href="index.php"><h1>Ogłoszenia</h1></a>
			</div>
			<div id="menu">
				<ul>
					<li><a href="index.php">Strona główna</a></li>
					<?php
					if ((empty($nick)) OR (empty($haslo)) OR (empty($user[id])) OR !isset($user[id])) {
					?>
					<li><a href="rejestracja.php"><b>Rejestracja</b></a></li>
					<?
					}
					else
					{ 
					?>
					<li><a href="dodaj.php">Dodaj ogłoszenie</a></li>
					<? } ?>
					
					<li><a href="regulamin.php">Regulamin</a></li>
					<li><a href="kontakt.php">Kontakt</a></li>
				</ul>
			</div>
		</div>
		<!-- end #header -->
		<div id="page">
			<div id="content">
								<div class="post"><br>