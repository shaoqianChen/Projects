#!/usr/local/bin/php
<?php 
ob_start();
session_start();
/** REGISTER USER 
	1. input user infos into validated table inside of 'val.db'
	2. delete user infos from invalidated table inside of 'inval.db'
**/


$email_input = $_SESSION['email'];
$hashed_password = $_SESSION['password'];


/*.   Operation on Validated user list    .*/
/*.       insert new register user into table validated.*/
class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('val.db');
    }
}
$mydb = new MyDB();
$statement = "INSERT INTO validated (email,password) VALUES ('$email_input','$hashed_password');";//insert user info into validated list
$run = $mydb->query($statement);//run the commend
$mydb->close();// close the connection for now

/*.Operation on invalidated */
/*. Delete the registed user from the invalidated table in inval.db .*/
class inval extends SQLite3{
    function __construct(){
        $this->open('inval.db');
    }
}
$mydb = new inval();
$statement = "DELETE FROM invalidated WHERE email= '$email_input';";//delete the pre-registed user from invalidated table
$run = $mydb->query($statement);
$mydb->close();// close the connection for now
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="validate.css">
    <meta http-equiv="refresh" content = "2; url = http://pic.ucla.edu/~schen13/Final_Project/index.php">
</head>
<body>
    <div class="registed-box">
        <h1>You are registered!</h1>   
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <input type="submit" value="Login" name="login_button" id="login_button">
            <p>
               <?php 
                    if (isset($_POST['login_button'])) {
                        
                        header('Location: http://pic.ucla.edu/~schen13/Final_Project/index.php');//redirect to this address
                        ob_end_flush();
                        die();                    
                    }
               ?> 
            </p>
        </form> 
    </div>

</body>
</html>