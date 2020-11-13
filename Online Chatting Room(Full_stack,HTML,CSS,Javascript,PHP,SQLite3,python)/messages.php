#!/usr/local/bin/php
<?php
//serve as the main chart window which displays all the messages that users send

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="messages.css">
	<script src="update.js" defer></script>
</head>
<body>
	
	<div id="new_messages">
	<?php
		//open chat_hist.db database
		class MyDB extends SQLite3{
		    function __construct(){
		        $this->open('chat_hist.db');
		    }
		}
		$mydb = new MyDB();
		$statement = "SELECT * FROM chat ORDER BY sent_time ASC;";//sort message by sent_time
		$run = $mydb->query($statement);
		// This is where the messages from the server go
		$display_message = "SELECT * FROM chat;";
		$run = $mydb->query($display_message);
		if ($run) {
			while ($row = $run->fetchArray()) {// while still a row to parse	
				echo $row['sent_time'],"<br>";	
				echo $row['username'], ":",str_repeat("&nbsp;", 10),$row['message'],"<br>","<br>";//print out all the messahges
				
			}
		}
		if (isset($_SESSION['user_submitted'])) {
			echo "New message sent";
			
		}
	?>
	</div>
</body>
</html>





