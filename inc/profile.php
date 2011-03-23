<?php

/*/          
 * ing/profile.php
 * Allows the user to change their profile information.
 * Nothing fancy, when user clicks submit the page is refreshed and the updated information is displayed. 
 * Otherwise errors are displayed using Ajax
 *
 * Usage: Imported by index when this page is requested
 *
 * Devs: Elise
 *
/*/

// Get sanitise function
include_once("database.php");

// Don"t send anything to the database if the form has not been filled in
if (!empty($_POST)){

  // Get the user id
  $id = $USER['id'];
  
  // Get date inputs
  if (isset($_POST["day"])) $day = sanitise($_POST["day"], 1); else $day = "";
  if (isset($_POST["month"])) $month = sanitise($_POST["month"], 1); else $month = "";
	if (isset($_POST["year"])) $year = sanitise($_POST["year"], 1); else $year = "";
		
	// Convert users date, month and year of birth into a timestamp
	$dobString = $day;
	$dobString .= "/";
	$dobString .= $month;
	$dobString .= "/";
	$dobString .= $year;
	$dob = strtotime($dobString);
	
	// Other inputs from form
	if (isset($_POST["gender"])) $gender = $_POST["gender"]; else $gender = "";
	if (isset($_POST["first_name"])) $first_name = sanitise($_POST["first_name"], 1); else $first_name = "";
	if (isset($_POST["parents_name"])) $parents_name = sanitise($_POST["parents_name"], 1); else $parents_name = "";
	if (isset($_POST["parents_email"])) $parents_email = sanitise($_POST["parents_email"], 1); else $parents_email = "";

	///////////////////// ERROR CHECKING \\\\\\\\\\\\\\\\\\\\\\\
		
	$noErrors = True;
	$error_message = "";
	$error_location = array("");

	// There is always a gender chosen as they could not have registered otherwise
  // Still perform check just in case..
  	if ( !isset($_POST['gender']) )
		{
			$noErrors = False;
			$error_message .= "<li> Are you a boy or a girl?"."\n";
		}

	// IS THE NAME VALID
	if ( strlen($first_name) < 2 
	    || empty($first_name)
	    || is_numeric($first_name)
	   )
	{
		$noErrors = False;
		$error_message .= "<li> Your name has to be at least 2 characters long and contain only letters!"."\n";
		array_push( $error_location, "first_name" );
	}

	// IS THE DATE OK
	if ( empty($day) || empty($month) || empty($year) ||
			 !ctype_digit($day) || !ctype_digit($month) || !ctype_digit($year) ||
			 !strlen($dobString) == 10 )
  {
    	$noErrors = False;
		$error_message .= "<li> You forgot to tell us when you were born! 
											Please use only numbers in the format DD MM YYYY, for example 02 11 2006"."\n";

		if ( empty($day) || !ctype_digit($day)) { array_push( $error_location, "day" ); }
		if ( empty($month) || !ctype_digit($month)) { array_push( $error_location, "month" ); }
		if ( empty($year) || !ctype_digit($year)) { array_push( $error_location, "year" ); }
  }	
  else if ( $day < 1 || $day > 31 
            || $month < 1 || $month > 12
            || $year < 1900 || $year > 2011
            || $day > 29 || $month == 02
            || $day > 30 && ( $month == 02 || $month == 04 || $month == 06 || $month == 09 || $month == 11)  
           )
  {
		$noErrors = False;
		$error_message .= "<li> Sorry, your date of birth doesn't seem to exist! 
											Are you sure this is when you were born?"."\n";

		if ( $day < 1 || $day > 31 ) { array_push( $error_location, "day" ); }
		if ( $month < 1 || $month > 12 ) { array_push( $error_location, "month" ); }
		if ( $year < 1900 || $year > 2011 ) { array_push( $error_location, "year" ); }
		if ( $day > 29 || $month == 02 
				 || $day > 30 && ( $month == 02 || $month == 04 || $month == 06 || $month == 09 || $month == 11)  ) 
		{ array_push( $error_location, "day", "month" ); }
			
  }

	// IS THE PARENT'S NAME VALID
	if ( strlen($parents_name) < 2 
	    || empty($parents_name)
	    || is_numeric($parents_name)
	   )
	{
		$noErrors = False;
		$error_message .= "<li> The parent's name has to be at least 2 characters long and contain only letters!"."\n";
		array_push( $error_location, "parents_name" );
	}

	// IS THE EMAIL VALID

	// Query the database to find a field that has the same value username as $username
	$resultemail = dbQuery('SELECT parents_email FROM users WHERE parents_email = "'. $parents_email .'" 
																												AND id != "'.$id.'"');  
		
	// We use a function to find how many rows correspond to $result
	// If there exists at least one, that means that the username is already taken
	if(mysql_num_rows($resultemail)>0)
  {
		$noErrors = False;
		$error_message .= "<li> This e-mail address seems to be in use! 
											Perhaps you have <a href=&#063;p&#061;lostPassword>forgot  your password?</a>";
		array_push( $error_location, "parents_email" );
	}
	else if(!validEmail($parents_email))
	{
    $noErrors = False;
    $error_message .= "<li> Please enter a correct email address"."\n";
    array_push( $error_location, "parents_email" );
  }

	////////////////////// END ERROR CHECKING \\\\\\\\\\\\\\\\\\\\

  // If they want a new password
  if( isset($_POST['password'])) 
  {

    // Generate a nine letter password that will be emailed to the user
		$password = threeLetterWord()."-".threeLetterWord()."-".threeLetterWord();
		$salt = randomStr(3);
		$saltPassword = md5(md5($password).$salt);

		////////////////////// SEND AN EMAIL \\\\\\\\\\\\\\\\\\\\
		// Modified from tutorial on http://www.phpeasystep.com/phptu/24.html

		$ccto = 'elisehein@gmail.com';
		$to = $parents_email;
		$subject = "Your new password";
		$header = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$header .= "From: Bernie <elisehein@gmail.com>";

		$message = "You have requested a new password to be sent to this email address."."\n\n";
		$message .= "You can now use the details below to login to your account:"."\n";
		$message .= "Username: ".$username."\n";
		$message .= "Password: ".$password."\n\n";
		$message .= "Have fun!";

		$emailSent = mail($to, $subject, $message, $header);
		
		// If no errors and the email was sent, update the database and go to the next page
		if ($noErrors && $emailSent)
		{

  		// Update user information with new password
		dbQuery("UPDATE users SET gender='$gender', 
		                          first_name='$first_name', 
		                          parents_email='$parents_email', 
		                          parents_name='$parents_name', 
		                          dob='$dob', 
		                          password='saltedPassword'
             WHERE id=$id");
    } // no errors
    else
    {
			$PAGE['error_message'] = nl2br(html_entity_decode($error_message));
			$PAGE['error_location'] = $error_location;
    } // errors
	} // new password	

  // If they didn't want a new password
	else 
	{
		// If no errors, update the database and go to the next page
		if ($noErrors)
		{

  			// Update user information with new password
			dbQuery("UPDATE users SET gender='$gender', 
		                          first_name='$first_name', 
		                          parents_email='$parents_email', 
		                          parents_name='$parents_name', 
		                          dob='$dob'
             WHERE id=$id");
    } // no errors
    else
    {
			$PAGE['error_message'] = nl2br(html_entity_decode($error_message));
			$PAGE['error_location'] = $error_location;
    }  // errors
	}	// no new password
}

?>


