<?php

/*/          
 * pages/editInterests.php
 * Allows the user to edit their interests
 * Uses the same form as includes/Form2 from the signup
 * 
 * Usage: Imported by index when this page is requested
 *
 * Devs: Niki & Elise
 *
/*/

/* Thinking Code */
// include_once('inc/editinterests.php');


// Don"t send anything to the database if the form has not been filled in
if (!empty($_POST))
{

  // First get an array of all the tags the user likes
  // This is so the form can display liked tags as checked when the user navigates to the page

	$id = $USER['id'];
  $query = dbQuery("SELECT tags FROM user_interests WHERE user_id = '$id'");
  $chosenInterests = array();
 
  while($row = mysql_fetch_array($query)) 
  {
	  $chosenInterests = unserialize($row['tags']);  
	}
	
	if (!$chosenInterests)
    $chosenInterests = array();

	$PAGE['chosen_interests'] = $chosenInterests;


	///////////////// NOW THE FORM SUBMITTING \\\\\\\\\\\\\\\\ 

	// Get all of the checked interests from the form, as an array
	if (isset($_POST["tags"])) $chosenTags = $_POST['tags']; else $chosenTags = array();

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
			$error_message = "<li> Please choose at least one interest!"; 
		}

	  // If no errors, update the database and go to the next page
		if ($noErrors)
		{
		  // Update the the tags field in the db (table user_interests, col tags, where id = $USER['id'])
	   	dbQuery("UPDATE user_interests SET tags = '$serialisedTags'");
	   	$PAGE['confirmation_message'] = "Your new interests have been saved!";
		 
		}	else {
			$PAGE['error_message'] = nl2br(html_entity_decode($error_message));
		}	
}


/* Rest of document just deals with displaying information not getting it */

$PAGE['title'] = "Edit interests";

$PAGE['content'] = parse("EditInterests.html");



?>
