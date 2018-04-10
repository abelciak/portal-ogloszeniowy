<?php 
@error_reporting(0);
@session_start();
mysql_connect("localhost","user","pass");
mysql_select_db("database");
mysql_query ('SET NAMES utf8');
?>