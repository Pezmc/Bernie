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
  
  //Error checking

  // Convert users date, month and year of birth into a timestamp
  $usersinput = sanitise($_POST["day"], 1);
  $usersinput .= "/";
  $usersinput .= sanitise($_POST["month"], 1);
  $usersinput .= "/";
  $usersinput .= sanitise($_POST["year"], 1);
  $dob = strtotime($usersinput);
  
  // CODE HERE to generate a nine letter password that will be emailed to the user
  $password = threeLetterWord()."-".threeLetterWord()."-".threeLetterWord();
  
  
  // Other inputs from form
  if (isset($_POST["gender"])) {$gender = sanitise($_POST["gender"], 1);} else $gender = "";
  if (isset($_POST["first_name"])) $first_name = sanitise($_POST["first_name"], 1); else $first_name = "";
  if (isset($_POST["username"])) $username = sanitise($_POST["username"], 1); else $username = "";
  if (isset($_POST["parents_name"])) $parents_name = sanitise($_POST["parents_name"], 1); else $parents_name = "";
  if (isset($_POST["parents_email"])) $parents_email = sanitise($_POST["parents_email"], 1); else $parents_email = "";
  
  $salt = randomStr(3);
  $saltPassword = md5(md5($password).$salt);
  
  // Create the user
  dbQuery("INSERT INTO users (gender, first_name, username, dob, parents_name, parents_email, password, salt) 
  				 VALUES ('".$gender."', '".$first_name."', '".$username."', '".$dob."', '".$parents_name."',
  				         '".$parents_email."', '".$saltPassword."', '".$salt."')");

	// Check for errors
	// If no errors, go to the next page
  	header("Location: /Bernie/?p=signup&id=2");
  				         
  //mail(); Could this be called after step two?
  } // step 1

  else if ($GLOBAL['id']==2)
  {
		// Get all of the checked interests from the form, as an array
		if (isset($_POST["tags[]"])) {$chosenTags = $_POST['tags[]'];} else $chosenTags = array();

		// Serialise the array
		$serialisedTags = serialize($chosenTags);

		// Get the current user id
		$user_id = $USER['id'];
		
		// Insert the array into the db (table user_interests, col tags, where id = $USER['id'])
		// Need to UPDATE if it already exists, or INSERT if row doesn't exist
		// At this step the user always exists as they have just finished step 1
		dbQuery("UPDATE user_interests SET tags='$serialisedTags' WHERE user_id=$user_id");
		
  } // step 2 
}

?>
