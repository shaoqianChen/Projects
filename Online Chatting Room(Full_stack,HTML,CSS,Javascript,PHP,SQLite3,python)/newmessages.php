#!/usr/local/bin/php
<?php ob_start();?>
<?php 
//where user can enter the new message and send to the char room
session_start();
date_default_timezone_set("America/Los_Angeles");//set default timezone

$email_input = $_SESSION['email'];
$username = $_SESSION['username'];

class MyDB extends SQLite3{//to access to the chat_hist.db
    function __construct(){
        $this->open('chat_hist.db');
    }
}
$mydb = new MyDB();
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="newmessages.css">
	<script type="username.js" defer></script>
</head>
<body>
	<div class="input_box">
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
		<textarea placeholder="Type here!" rows="8" cols="200" name="message"></textarea>
		
		<input type="submit" name="Send" value="Send" \>
	</form>
	<p>
	<?php
		$_SESSION['user_submitted']=$_POST['Send'];
		if (isset($_POST['Send'])) {//Once user try to send th message
			$current_time = date("Y-m-d h:i:sa");
			$message = $_POST['message'];
			echo "Message Sent.";
			/*UPDATE chat.db*/

			$statement = "INSERT INTO chat(email, username, message, sent_time) VALUES ('$email_input','$username','$message','$current_time');";
			$run = $mydb->query($statement);


			/**Write the whole message into a .txt file**/
			$file = 'user.txt';
			$myfile = fopen($file,"w") or die("Unable to open file!");
			$txt = $username.":   ".$message."    ".$current_time;
			fwrite($myfile, $txt);
			fclose($myfile);
		}
	?>
	</p>
	</div>
</body>
</html>