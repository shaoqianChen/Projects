#!/usr/local/bin/php
<?php 
//a file serve as the main chatroom windows 
//will be split into three parts
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="welcome.css">
	<title>Welcome to the Chatroom</title>
</head>
	<frameset id="the_frameset" allowtransparency="true" cols="200,*">
		<frame src = "slidebar.php">
		<frameset rows="*,200" >
			<frame src = "messages.php">
			<frame src = "newmessages.php">		
		</frameset>
	</framesetT>
</html>