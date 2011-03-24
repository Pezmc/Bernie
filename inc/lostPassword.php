<?php

/*/          
 * inc/lostPassword.php
 *
 * Devs: Florin
 *
/*/

if (!empty($_POST))
{
	// If they have just entered they're email address send them a confirmation key
  	if ( isset($_POST['email']) )
  	{
  		// Get the emal from the form
  		$email = sanitise($_POST['email'], 1);

		// Create the variables to display errors
		$noErrors = True;
		$error_message = "";
		$confirmation_message = "";
	
  		// Check whether the email exists in the database
  		$result = dbQuery("SELECT id FROM users WHERE parents_email = '$email' LIMIT 1");

  		// If not
  		if (mysql_num_rows($result) == 0)
  		{
  			$noErrors = False;
			$error_message = '<li> Sorry - this email does not seem to exist! ';
    		$error_message .= "Have you <a href='?p=signup'>signed up</a>?";
 		}

		// Check whether the email address is valid
		if(!validEmail($email))
		{
    		$noErrors = False;
    		$error_message .= "<li> Please enter a correct email address"."\n";
		}
		
  	  // Get the row of the user
	  	$row = mysql_fetch_array($result);

	  	// Generate a random passkey
	  $passkey = md5(rand());

	  

	  // Get the id of the person with this email
		$id = $row['id'];

    // Insert the passkey into the database
	  dbQuery("UPDATE users SET confirmation_code = '$passkey' WHERE id = '$id' ");

	  // Send them an email with the passkey
		$to = $email;
		$subject = "Recover Bernie password";
		$header = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$header .= "From: Bernie <bernie@server.pezcuckow.com>";

		$message = "You have requested for a new password on Bernie. Click on the link below to retrieve it."."\n\n";
		$message .= "http://server.pezcuckow.com/Bernie/?p=lostPassword&passkey=$passkey";

	  $emailSent = mail($to, $subject, $message, $header);

	  // If the email is sent, show them a confirmation message
	  if (!$emailSent)
	  {
	    	$noErrors = False; 
			$error_message .= "Something went wrong, the email has not been sent..."; 
		}	

		// If there are no errors
		if ($emailSent && $noErrors)
	  {
			$PAGE['confirmation_message'] = "Check your email!";
		}

		// Else show them an error message
	  else
	  {
  			$PAGE['error_message'] = nl2br(html_entity_decode($error_message));
  		}
  	}
  	// Else if they have clicked on the link in the email
	else if (isset($_GET['passkey']))
	{
		// Get the passkey
		$passkey = sanitise($_GET['passkey']);

		// Get the user with this passkey
  		$result = dbQuery("SELECT id FROM users WHERE confirmation_code = '$passkey' LIMIT 1");

  		// Create the variables to display errors
		$noErrors = True;
		$error_message = "";
		$confirmation_message = "";

  		// If this user doesn't exists
  		if (mysql_num_rows($result) == 0)
  		{
			$noErrors = False;
			$error_message .= "This user does not seem to exist!";
  		}
  	
		// If there are no errors
		if ( $noErrors )
		{
			// Generate a new password
    		$password = threeLetterWord()."-".threeLetterWord()."-".threeLetterWord();
    		$salt = randomStr(3);
    		$saltPassword = md5(md5($password).$salt);

    		// Put this password in the database
    		dbQuery("UPDATE users SET password = '$saltPassword' WHERE confirmation_code = '$passkey'");

			$confirmation_message = "Your password has been reset. ";
    		$confirmation_message = "Your new password is <b>".$password."</b>";
    		$PAGE['confirmation_message'] = nl2br(html_entity_decode($confirmation_message));
		}
		else
		{
    		$PAGE['error_message'] = nl2br(html_entity_decode($error_message));
  		}
	}
}

?>
  	
