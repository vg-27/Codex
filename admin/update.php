<?php
require '../db_info.php';
$db = mysqli_connect('localhost', $username, $password, $database);
if (!$db) {  die('Not connected : ' . mysqli_error($db));}
if (isset($_GET['act'])) {
      	$id = $_GET['id'];
      	$req = $_GET['act'];
      	if ($req == 1) {
      		$quv = "UPDATE alerts SET flag = 1 WHERE alerts.id =".$id;
	      	$resv = mysqli_query($db, $quv);
	      	if (!$resv) {
			  die('Invalid query: ' . mysqli_error($db));
			}
      	}
      	if ($req == 0) {
      		$qud = "DELETE FROM alerts WHERE alerts.id =".$id;
      		$resd = mysqli_query($db, $qud);
	      	if (!$resd) {
			  die('Invalid query: ' . mysqli_error($db));
			}
      	}
	}
?>