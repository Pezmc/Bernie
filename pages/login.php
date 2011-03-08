<?php

/*/          
 * pages/login.php
 * System processes logging in and out, should redirect to home everytime
 *
 * Usage: Imported by index when this page is requested
 *
 * Devs: Florin
 *
/*/

/* Thinking Code */
include_once('inc/login.php');

/* Rest of document just deals with displaying information not getting it */

//Currently just let them in anyway and send them home
validateUser(round(rand(1,2)));
header('Location: ?p=home');

/***** HELP FROM PEZ *****/
/* When you check the login you need to get username, password and salt from database where username = the username they said
/* If that doesn't exist error
/* If that does exist check if the password (hash) is equal to the hash you created for the username
/* I suggested this if(md5(salt.md5(PostedPassword) == PasswordFromDB)*/

?>
