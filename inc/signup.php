<?php

/*/          
 * ing/signup.php
 * Allows the user to register and set up a new account to start " bernieing". In this section has two parts to it. 
 * Step 1, where the user enters their personal details and their parents email address.
 * Step 2 where the user is able to like particular categories. The generated items the viewer sees later on are based on these liked categories. 
 *
 * Global $GLOBAL["id"] 1 is for step 1, 2 is for step 2, 3 is for finished
 *
 * Usage: Imported by index when this page is requested
 *
 * Devs: Niki
 *
/*/

// Don"t send anything to the database if the form has not been filled in
if (!empty($_POST)){
  //Logic to decide whether we are on page 1 or two
  if ($GLOBAL['id']==1)
  {
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
		
		// Generate a nine letter password that will be emailed to the user
		$password = threeLetterWord()."-".threeLetterWord()."-".threeLetterWord();
		$salt = randomStr(3);
		$saltPassword = md5(md5($password).$salt);
		
		// Other inputs from form
		if (isset($_POST["gender"])) $gender = sanitise($_POST["gender"], 1); else $gender = "";
		if (isset($_POST["first_name"])) $first_name = sanitise($_POST["first_name"], 1); else $first_name = "";
		if (isset($_POST["username"])) $username = sanitise($_POST["username"], 1); else $username = "";
		if (isset($_POST["parents_name"])) $parents_name = sanitise($_POST["parents_name"], 1); else $parents_name = "";
		if (isset($_POST["parents_email"])) $parents_email = sanitise($_POST["parents_email"], 1); else $parents_email = "";

		///////////////////// ERROR CHECKING \\\\\\\\\\\\\\\\\\\\\\\
		
		$noErrors = True;
		$error_message = "";
		$error_location = array("");

		// IS THERE A GENDER
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
			array_push($error_location, "first_name");
		}

		// IS THE USERNAME VALID

		// Query the database to find a field that has the same value username as $username
	  $resultuser = dbQuery('SELECT username FROM users WHERE username = "'. $username .'"');  
	
		if(mysql_num_rows($resultuser)>0)
	  {
			$noErrors = False;
			$error_message .= "<li> This username seems to already exist! 
												Perhaps you have <a href=&#063;p&#061;lostPassword>forgot  your password?</a>";
			array_push($error_location, "username");
	  }
		else if ( strlen($username) < 3 
		    || empty($username)
		   )
		{
			$noErrors = False;
			$error_message .= "<li> Your username has to be at least 3 characters long!"."\n";
			array_push($error_location, "username");
		}
	
		// IS THE DATE OK
		if ( empty($day) || empty($month) || empty($year) ||
						 !ctype_digit($day) || !ctype_digit($month) || !ctype_digit($year) ||
						 !strlen($dobString) == 10 )
    {
			$noErrors = False;
			$error_message .= "<li> You forgot to tell us when you were born! 
												Please use only numbers in the format DD MM YYYY, for example 02 11 2006"."\n";

			if ( empty($day) || !ctype_digit($day)) { array_push($error_location, "day"); }
			if ( empty($month) || !ctype_digit($month)) { array_push($error_location, "month"); }
			if ( empty($year) || !ctype_digit($year)) { array_push($error_location, "year"); }

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

			if ( $day < 1 || $day > 31 ) { array_push($error_location, "day"); }
			if ( $month < 1 || $month > 12 ) { array_push($error_location, "month"); }
			if ( $year < 1900 || $year > 2011 ) { array_push($error_location, "year"); }
			if ( $day > 29 || $month == 02 
					 || $day > 30 && ( $month == 02 || $month == 04 || $month == 06 || $month == 09 || $month == 11)  ) 
			{ array_push($error_location, "day", "month"); }
			
    }

		// IS THE PARENT'S NAME VALID
		if ( strlen($parents_name) < 2 
		    || empty($parents_name)
		    || is_numeric($parents_name)
		   )
		{
			$noErrors = False;
			$error_message .= "<li> The parent's name has to be at least 2 characters long and contain only letters!"."\n";
			array_push($error_location, "parents_name");
		}

		// IS THE EMAIL VALID

		// Query the database to find a field that has the same value username as $username
	  $resultemail = dbQuery('SELECT parents_email FROM users WHERE parents_email = "'. $parents_email .'"');  
		
	  // We use a function to find how many rows correspond to $result
	  // If there exists at least one, that means that the username is already taken
	  if(mysql_num_rows($resultemail)>0)
	  {
			$noErrors = False;
			$error_message .= "<li> This e-mail address seems to be in use! 
												Perhaps you have <a href=&#063;p&#061;lostPassword>forgot  your password?</a>";
			array_push($error_location, "parents_email");
	  }
		else if(!validEmail($parents_email))
		{
      $noErrors = False;
      $error_message .= "<li> Please enter a correct email address"."\n";
			$error_location[] = "parents_email";
      //array_push($error_location, "parents_email");
		}

		////////////////////// END ERROR CHECKING \\\\\\\\\\\\\\\\\\\\\\\\\\\\
		
		// If no errors, update the database and go to the next page
		if ($noErrors)
		{
		  // Create the user
		  dbQuery("INSERT INTO users (gender, first_name, username, dob, parents_name, parents_email, password, salt) 
						 VALUES ('".$gender."', '".$first_name."', '".$username."', '".$dob."', '".$parents_name."',
						         '".$parents_email."', '".$saltPassword."', '".$salt."')");

		  header("Location: /Bernie/?p=signup&id=2");
		}	else {
			$PAGE['error_message'] = nl2br(html_entity_decode($error_message)); 
			$PAGE['error_location'] = $error_location;
		}		
  	         
  } // step 1

  else if ($GLOBAL['id']==2)
  {
		// Get all of the checked interests from the form, as an array
		if (isset($_POST["tags[]"])) {$chosenTags = $_POST['tags[]'];} else $chosenTags = array();

		// Serialise the array
		$serialisedTags = serialize($chosenTags);

		// Get the current user id
		$user_id = $USER['id'];
	
		// Check for errors (only one possible: 0 tags chosen)
		$noErrors = True;
		$error_message = "";

		if ( count($chosenTags) < 1 )
		{
			$noErrors = False;
			$error_message = "<li> Please choose at least one iterest!"; 
		}

	  // If no errors, update the database and go to the next page
		if ($noErrors)
		{
		  // Insert the array into the db (table user_interests, col tags, where id = $USER['id'])
   		// At this step the user always exists as they have just finished step 1
	   	dbQuery("UPDATE user_interests SET tags='$serialisedTags' WHERE user_id=$user_id");
		  header("Location: /Bernie/?p=signup&id=3");
		}	else {
			$PAGE['error_message'] = nl2br(html_entity_decode($error_message));
		}	
  				         
  } // step 2 
  else if ($GLOBAL['id']==3)
  {
  //mail(); Could this be called after step two?
  }
}

?>
