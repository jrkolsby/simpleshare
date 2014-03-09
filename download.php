<?php
	include "credentials.php";
	
	$link = mysql_connect('localhost', $credentials['db_user'], $credentials['db_pass']); 
	if (!$link) { 
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db($credentials['db_name']);
	
	$time = $_POST["time"];
	$download = "t";
	
	mysql_query("UPDATE files SET download='$download' WHERE time='$time'");

	$f = $_POST["file"];
	header("Content-type: ".filetype('files/'.$f));
	header('Content-disposition: attachment; filename="'.$f.'"');
	echo file_get_contents('files/'.$f);
	
	unlink('files/'.$f);
	exit;
?> 