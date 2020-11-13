#!/usr/local/bin/php
<?php ob_start();?>

<?php 
//At left of every welcome.php
//displays user's info and allow user to log out
session_start();
date_default_timezone_set("America/Los_Angeles");//set default timezone

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="slidebar.css">
</head>
<body>
	<?php
	$email_input = $_SESSION['email'];//get user's login email
	$username = $_SESSION['username'];//get user's login username
	$message = "Just left this room";
	$current_time = date("Y-m-d h:i:sa");//get the current time

	echo "Hello, ","<br>";
	echo $email_input;
	echo "<br>","You just joined this chatroom as ",$username;

	//create a class constructor to open the db file
	class MyDB extends SQLite3{
	    function __construct(){
	        $this->open('chat_hist.db');
	    }
	}
	$mydb = new MyDB();
	?>
	<div class="input_box">
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >	
		<input type="submit" name="Log_out" value="Log out"/>
		<?php 
			if (isset($_POST['Log_out'])) {//once the user choose to log out
				$statement = "INSERT INTO chat(email, username, message, sent_time) VALUES ('$email_input','$username','$message','$current_time');";
				$run = $mydb->query($statement);

				//redirect user to other page using javascript
				echo "
					<script type='text/javascript'>
					window.top.location.href = 'http://www.pic.ucla.edu/~schen13/Final_Project/logout.php';
					</script>
				";
			}
		?> 
	</form>
	</div>

</body>
</html>