<title>Portal ogłoszeniowy</title>
<?
include 'include/gora.php';
//START TREŚCI
include("config.php");
?>			
<div id="colA">
		<h3>Regulamin</h3>	

<?
$rekord = @mysql_fetch_array(@mysql_query ("SELECT * FROM podstrony WHERE podstrona = '1'"));
	echo $rekord['zawartosc'];
?>		
					

				</div>
<?

//KONIEC TREŚĆI!
include 'include/bok.php';
include 'include/stopka.php';
?>
				
				
			
			