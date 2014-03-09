<!DOCTYPE html>
<head>
<title>Simlpe Share</title>
<meta name="description" content="Upload files knowing that only one other person will download them">
<meta name="robots" content="ALL">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="global.css" rel="stylesheet" type="text/css" />
<style type="text/css" media="only screen and (max-device-width: 1024px)">
body {
min-width: 1024px;
}
</style>
<style type="text/css" media="only screen and (max-device-width: 480px)">
body {
min-width: 480px;
}
</style>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="sto/retina.js"></script> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="sto/main.js"></script>
</head>
<body>
<div title="Upload Files" id="upload-button"></div>
<div id="loading"></div>
<div id="shadow"></div>
<form enctype="multipart/form-data" id="upload" method="POST" action="send.php">
<input type="hidden" name="MAX_FILE_SIZE" value="104857600" />
<input id="fileInput" type="file" name="file" />
<button id="fileButton" onclick="return false;">Choose a file</button>
<h3>Max 100mb</h3>
</form>
<form id="download" method="post" action="download.php">
<input id="fileDownload" type="hidden" name="file">
<input id="timeDownload" type="hidden" name="time">
</form>
<div id="content">
<?php
	include "credentials.php";
	$link = mysql_connect('localhost', $credentials['db_user'], $credentials['db_pass']); 
	if (!$link) { 
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db($credentials['db_name']);
	
	$query = "SELECT * FROM files ORDER BY time DESC"; 
	$result = mysql_query($query) or die(mysql_error());
	while($row = mysql_fetch_array($result)){
		if ($row[download] == "f") {
			print "<div data='" . $row[time] . "' ref='" . $row[newName] . "' class='" . $row[type] . " file'><h2>";
			print $row[oldName] . "</h2></div>";	
		} else {
			print "<div class='" . $row[type] . " file downloaded'><h2>";
			print $row[oldName] . "</h2></div>";
		}
	}
?>

</div>