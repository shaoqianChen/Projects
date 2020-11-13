#!/usr/local/bin/php
<?php ob_start();?>
<?php
	session_start();
	date_default_timezone_set("America/Los_Angeles");//set default timezone

	/****************************************/
	/**CREATE database for INVALIDATED users**/
	try{
		$mydb = new SQLite3('inval.db'); // opens or creates the database
	}
	catch(Exception $ex){// may throw
		echo $ex->getMessage();
	}
	$statement = 'CREATE TABLE IF NOT EXISTS invalidated(email TEXT PRIMARY KEY, password TEXT);';//create a table to store invalidated user in inval.db
	$run = $mydb->query($statement);
	$mydb->close();// close the connection for now

	/****************************************/
	/**CREATE database for VALIDATED users**/
	try{// attempt to establish connection
		$mydb = new SQLite3('val.db');
	}
	catch(Exception $ex){// may throw
		echo $ex->getMessage();
	}
	$statement = 'CREATE TABLE IF NOT EXISTS validated(email TEXT PRIMARY KEY, password TEXT);';//create a table to store validated user in val.db
	$run = $mydb->query($statement);// run the command
	$mydb->close();// close the connection for now

	/****************************************/
	/**CREATE database for chatting history**/
	try{
		$mydb = new SQLite3('chat_hist.db');//opens or creates the database
	}
	catch(Exception $ex){// may throw
		echo $ex->getMessage();
		echo "Exception caught";
	}
	$statement = 'CREATE TABLE IF NOT EXISTS chat(email TEXT, username TEXT, message TEXT, sent_time TEXT);';//create a table to store user's email,name,input and current time
	$run = $mydb->query($statement);//run the commend
	$mydb->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Main Page</title>
	<a href="validat.php"></a>
	<link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>


	<div class="login-box">
		<h1>Login Here</h1>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		
			<label for="email">Email Address: </label>
			<input type="email" pattern="^\w+@[a-zA-Z_]+?\.[a-zA-Z]{1,4}+(\.[a-zA-Z]{1,4})?$" name="email" id="email" >

			<br>
			<label for="password">Password (≥6 characters letters or digits): </label>
			<input type="password" pattern="^[a-zA-Z0-9]{6,}$" name="password" id="password">
	
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<div id="lower">
				<input type="submit" value="Register" name = "register_button" id="Register" />
				<input type="submit" value="Log in" name="login_button" id="Log in" />
				<a href="http://www.pic.ucla.edu/~schen13/Final_Project/forget_password.php" target="_blank" rel="noopener"><u>Forgot your password?</u></a>
				</div>
			
			</form>
			
			<p>

		<?php

			$email_input = $_POST['email']; //get user's input email
			$password_input = $_POST['password']; //get user's input password
			$hash_value=hash('md2', $password_input);//hash the password
			$_SESSION['email'] = $email_input;//make the email global
			$_SESSION['password'] = $hash_value;//make the hashed password global

					/*CASE ONE*/
			/*User Press the REGISTER button*/
			/*   							*/
			/*   							*/
			if (isset($_POST['register_button'])) {//check if the user clicked REGISTER button

				/*GET the number of input email in validated table */
				$mydb->open('val.db');//connect to val.db database
				//$email_input = $_POST['email']; 
				
				$find_email = "SELECT count(*) FROM validated WHERE email = '$email_input';";// return the number of row for the required element
				$result = $mydb->query($find_email);//run the commend


				if ($result) {//so no error in the query
					while($row = $result->fetchArray()){//while still a row to parse
						$num_of_same_email = $row['count(*)'];//print the string represent how many ele in the table
						}
					}
				$mydb->close();//close the connection

				/*CASE 1.1*/
				/**User's inputed email haven't registered yet**/
				if ($num_of_same_email=="0") {//if the input email is not registered

					/*/Insert the unregistered infos into invalidated table inside of inval.db/*/
					$mydb->open('inval.db');
					$statement = "INSERT INTO invalidated(email,password) VALUES('$email_input','$hash_value');";
					$mydb->query($statement);
					$mydb->close();

					echo "A validation email has been sent to: ", $email_input,". Please follow the link.";
					/*SENDING VALIDATION EMAIL*/
					$to = $email_input;
	        	 	$subject = "Validation Email";
	        	 	$message = "<b>Validate by click the link here: </b>";
	         		$message .= "<p>http://pic.ucla.edu/~schen13/Final_Project/validate.php/?email=$email_input&token=$hash_value</p>";
	         		$header = "From: schen13@g.ucla.edu \r\n";
	         		$header .= "MIME-Version: 1.0\r\n";
	         		$header .= "Content-type: text/html\r\n";
	         		$retval = mail ($to,$subject,$message,$header);
				}

				/*CASE 1.2*/
				/**User's inputed email is registered **/
				else { //otherwise the email is already registered
					echo "Already registered. Please log in.";
				}
			}
			/*   							*/
			/*   							*/
			/********************************/
					   /*CASE TWO*/
			/*User pressed the LOGIN button */
			/*   							*/
			/*   							*/
			elseif (isset($_POST['login_button'])) {//check if the user clicked LOGIN button
				//echo "login_button pressed","<br>","Email: ",$_POST['email'];
				//email registered
				$mydb->open('val.db');//connect to val.db database
				$find_email = "SELECT count(*) FROM validated WHERE email = '$email_input';";// return the number of row for the required element
				$result = $mydb->query($find_email);//run the commend
				if ($result) {//so no error in the query
					while($row = $result->fetchArray()){//while still a row to parse
						$num_of_same_email = $row['count(*)'];//print the string represent how many ele in the table
						}
					}
				/*CASE 2.1*/
				/**User's inputed email is not registered **/
				if ($num_of_same_email == "0") {// if did not find this user registered
					echo "No such email address. Please register or validate";
				}
				/*CASE 2.2*/
				/**User's inputed email is registered **/
				else {//otherwise the user exits
					$find_password = "SELECT count(*) FROM validated WHERE password = '$hash_value';";
					$result = $mydb->query($find_password);
					if($result){
						while($row = $result->fetchArray()){
							$num_of_same_password = $row['count(*)'];// define the string represent how many same password in the table
						}
					}
					if ($num_of_same_password == "0") { //if the user enter the wrong password
						echo "Your password is invalid";
					}
					else{ // otherwise the password is correct and continue
						echo "your password is correct";
						//if no username
							//go to welcome_zero.php
						//else
						//	go to welcome.php
						header('Location: welcome_zero.php');
					}	
				}
			}
		?>
			</p>

		</form>
	</div>

</body>

</html>