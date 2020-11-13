#!/usr/local/bin/php
<?php ob_start();?>
<?php 
session_start();//start a session
date_default_timezone_set("America/Los_Angeles");//set default timezone
$email_input = $_SESSION['email'];

//create a class constructor to open the db file
class MyDB extends SQLite3{
    function __construct(){
        $this->open('chat_hist.db');
    }
}
$mydb = new MyDB();


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="welcome_zero.css">
	<title>Welcome</title>
</head>
<body>
	<main>
		<div class="login-box">
			<h1>Username</h1>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
				<label>Enter a username</label>
				<input type="text" name="username" id="username" />
				<div id="lower">
					<input type="submit" value="Confirm" name="confirm_button" id="confirm_button">
				</div>
			</form>
		</div> 
		<p><?php
			$username = $_POST['username'];
			$_SESSION['username'] = $username;

			/**if user click confirm button, they will redirect to the main chatting site: welcome.php**/
			if (isset($_POST['confirm_button'])) {
				/*INSERT USERNAME*/
					/**CASE 1*/
					/**The username with same email already existed**/
					//Ask user to renter

					/**CASE 2*/
					/**The username with same email not exist**/
					/**insert the username into the chat_hist.db along with its email**/
					$current_time = date("Y-m-d h:i:sa");
					$message = $username." just joined this chatroom!";
					$statement = "INSERT INTO chat(email, username, message, sent_time) VALUES ('$email_input','$username','$message','$current_time');";
					$run = $mydb->query($statement);

				ob_start();
				header('Location: welcome.php');//redirect to this address
				ob_end_flush();
				die();
			}

			
			?></p>
	</main>
</body>
</html>