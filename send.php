<?php
define("UPLOAD_DIR", "files/");

include "credentials.php";
 
if (!empty($_FILES["file"])) {
	
	$link = mysql_connect('localhost', $credentials['db_user'], $credentials['db_pass']); 
	if (!$link) { 
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db($credentials['db_name']);
	
	$file = $_FILES["file"];
	
	$imageArray = array("jfif", "jpeg", "tiff", "raw", "gif", "png", "svg", "ai", "psd", "jpg");
	$videoArray = array("mpeg", "mpg", "mpe", "mpeg-1", "mpeg-2", "mpa", "mp2", "m2a", "mov", "qt", "wmv", "rm", "mp4", "avi", "m4v");
	$musicArray = array("mp3", "wma", "wav", "ra", "mid", "ogg", "m4a");
	$codeArray = array("c", "class", "cmd", "css", "java", "h", "m", "sh", "js", "pyc", "pyd", "pyo", "rb", "terminal");
	$textArray = array("ascii", "txt", "doc", "docx", "rtf", "pdf", "docxml", "log", "plist", "me", "sublime-project", "text", "xml");
	$archiveArray = array("jar", "tar", "zip", "pkg", "lzip", "gzip");
 
	if ($file["error"] !== UPLOAD_ERR_OK) {
		echo "<meta http-equiv='REFRESH' content='0;url=http://jmkl.co/simpleshare/'>";
		exit;
	}
	
	$extension = pathinfo($file["name"], PATHINFO_EXTENSION);
	$extension = strtolower($extension);
	
	if (in_array($extension, $imageArray)) {
		$type = "image";
	} else if (in_array($extension, $videoArray)) {
		$type = "video";		
	} else if (in_array($extension, $musicArray)) {
		$type = "music";		
	} else if (in_array($extension, $codeArray)) {
		$type = "code";		
	} else if (in_array($extension, $textArray)) {
		$type = "text";		
	} else if (in_array($extension, $archiveArray)) {
		$type = "archive";		
	} else {
		echo "<meta http-equiv='REFRESH' content='0;url=http://jmkl.co/simpleshare/'>";
		exit;
	}
	
	$oldName = substr(str_replace("." . $extension, "", strtolower($file["name"])), 0, 20);
	$oldName = str_replace("'", "", $oldName);
	$oldName = str_replace("<", "", $oldName);
	$oldName = str_replace(">", "", $oldName);
	$newName = $oldName . "." . $extension;
	
	$newName = 	preg_replace("/[^A-Z0-9._-]/i", "_", $newName);
	
	$parts = pathinfo($newName);
	while (file_exists(UPLOAD_DIR . $newName)) {
		$i++;
		$newName = $parts["filename"] . "-" . $i . "." . $parts["extension"];
	}
	$success = move_uploaded_file($file["tmp_name"], UPLOAD_DIR . $newName);
	if (!$success) {
		echo "<meta http-equiv='REFRESH' content='0;url=http://jmkl.co/simpleshare/'>";
		exit;
	}
	chmod(UPLOAD_DIR . $newName, 0644);
	
	$time = time();
	$download = "f";
	
	mysql_query("INSERT INTO files (`time`, `type`, `oldName`, `newName`, `download`) VALUES ('$time', '$type', '$oldName', '$newName', '$download')");
	echo "<meta http-equiv='REFRESH' content='0;url=http://jmkl.co/simpleshare/'>";
	

}