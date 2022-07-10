<?php
	$feed = file_get_contents('php://input');

	$rep =  @json_decode($feed, true);

    header("Content-Type: application/json");
    header("Cache-Control: max-age=0");
    header("Accept-Ranges: none");
    header("Content-Disposition: inline;");
	echo json_encode($rep);
	
?>