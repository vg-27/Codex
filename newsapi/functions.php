<?php
	$urlSoureces = file_get_contents( "https://newsapi.org/v1/sources?language=en");
	$urlContent = json_decode($urlSoureces, true);
	$sources = $urlContent['sources'];

	for ($i=0; $i < count($sources); $i++) { 
		
	}

	print_r($sources);
?>