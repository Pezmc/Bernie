<?php

session_start();

function validateUser()
{
    session_regenerate_id (); //this is a security measure
    $_SESSION['valid'] = 1;
    $_SESSION['userid'] = $userid;
}

//if the user has not logged in
if(!isLoggedIn())
{
    header('Location: index.php');
    die();
}
//page content follows
echo "Awesome, you're logged in"


?>
