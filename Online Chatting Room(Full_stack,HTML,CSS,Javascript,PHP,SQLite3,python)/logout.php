#!/usr/local/bin/php
<?php 
//The Log out page
ob_start();
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="refresh" content = "5; url = http://pic.ucla.edu/~schen13/Final_Project/index.php">
	<link rel="stylesheet" type="text/css" href="logout.css">
	<title></title>
</head>
<body>

 	<main>
 		<div class="logout-box">
			<h1>You've Logged out</h1>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
				<div id="lower">
					<label>You will be redirected to the log in page after 5 seconds</label>
				</div>
			</form>
		</div> 
 	</main>
</body>
</html>