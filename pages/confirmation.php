<?php

/*/          
 * inc/confirmation.php
 * Used to verify the user after they have clicked on the link they got in the email
 * 1. Check the passkey
 * 2. If the passkey matches the one in the database, change the users active field from 0 to 1
 * 3. If the active field is already 1, do nothing
 *
 * Modified from tutorial on http://www.phpeasystep.com/phptu/24.html
 * Usage: Used by signup.php 
 *
 * Devs: Elise
/*/

/* Thinking Code */
include_once('inc/signup.php');

/* Rest of document just deals with displaying information not getting it */

$PAGE['title'] = "Account confirmed";

// Passkey that got from link 
$passkey = $_GET['passkey'];

// Get the activation field from the users table whose passkey matches their confirmation code
$matchFound = dbQuery("SELECT active FROM users WHERE confirmation_code ='$passkey'");

// If successfully queried 
if ( $matchFound ) 
{
	// There should be just one passkey like this
	$count = mysql_num_rows($matchFound);
	
	if($count==1)
	{
		// Make this user active
		$userNowActive = dbQuery("UPDATE users SET active = '1' WHERE confirmation_code ='$passkey'");
	}

	// Otherwise...
	else 
	{
		$PAGE['content'] = "Sorry - this confirmation code does not seem to exist! Are you sure you have signed up?";
  }

	// If the dbQuery was successful, display a confirmation message
	if ( $userNowActive )
	{
		$PAGE['content'] = "Yay! Your account has been verified! You can now log in to begin Berying!";
	}
}

?>
