<?php

/*/          
 * pages/signup.php
 * Allows the user to register and set up a new account to start ' bernieing'. In this section has two parts to it. 
 * Step 1, where the user enters their personal details and their parents email address.
 * Step 2 where the user is able to like particular categories. The generated items the viewer sees later on are based on these liked categories. 
 *
 * Global $GLOBAL['id'] 1 is for step 1, 2 is for step 2, 3 is for finished
 *
 * Usage: Imported by index when this page is requested
 *
 * Devs: Niki
 *
/*/

/* Thinking Code */
include_once('inc/signup.php');

/* Rest of document just deals with displaying information not getting it */


/***** HELP FROM PEZ *****/
/* When you give them username or password
/* use randomStr(3) to create a random three letter string
/* Then when you hash the password do something like md5(randomStr(3).md5($password))
/* Store that value in the database, along with the random string (the SALT)
/* Makes it much harder to hack the website */

?>
