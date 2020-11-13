#!/usr/local/bin/php
<?php ob_start(); ?>
<?php

session_start();
$email_input = $_SESSION['email'];
echo $email_input;

/**1. Clear user's infor from val.db **/
/**2. Redirect user to index.php.    **/

class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('val.db');
    }
}
$mydb = new MyDB();


/*GET the number of input email in validated table */

$find_email = "SELECT count(*) FROM validated WHERE email = '$email_input';";// return the number of row for the required element
$result = $mydb->query($find_email);//run the commend

if ($result) {//so no error in the query
	while($row = $result->fetchArray()){//while still a row to parse
		$num_of_same_email = $row['count(*)'];//print the string represent how many ele in the table
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="forget_password.css">
	<meta http-equiv="refresh" content = "5; url = http://pic.ucla.edu/~schen13/Final_Project/index.php">
</head>
<body>
	<main>
		<div class="forgetpass-box">
			<?php
			if ($num_of_same_email=="0") {
	
			?>
				<h1>You have not registed yet.</h1>
			<?php
				}
			else{
			?>
				<h1>You can now register again</h1>
			<?php
				$statement = "DELETE FROM validated WHERE email = '$email_input';";//delete the registed user from validated table so this user can re register
				$run = $mydb->query($statement);
				$mydb->close();//close the connection
			}

			?>
			
			<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
				<label>You will be redirected to the log in page after 5 seconds</label>
				<p><?php echo $email_input; ?></p>
			</form>
		</div>
	</main>
</body>
</html>