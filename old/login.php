<?php

/*/          
 * pages/login.php
 * This will allow the user to change all their personal settings which they entered during step one of the sign up process
 * Global $GLOBAL['id'] 1 is for edit profile, 2 is for edit interests
 *
 * Usage: Imported by index when this page is requested
 *
 * Devs: Florin
 *
/*/


/*session_start(); //must call session_start before using any $_SESSION variables
$username = $_POST['username'];
$password = $_POST['password'];
//connect to the database here
$username = mysql_real_escape_string($username);
$query = "SELECT password, salt
        FROM users
        WHERE username = '$username';";
$result = mysql_query($query);
if(mysql_num_rows($result) < 1) //no such user exists
{
    header('Location: ?p=home');
    die();
}
$userData = mysql_fetch_array($result, MYSQL_ASSOC);
$hash = hash('sha256', $userData['salt'] . hash('sha256', $password) );
if($hash != $userData['password']) //incorrect password
{
    header('Location: ?p=home');
    die();
}
else
{
    validateUser(); //sets the session data for this user
}
//redirect to another page or display "login success" messag*/

?>
