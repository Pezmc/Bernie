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

  // Convert users date, month and year of birth into a timestamp
  $usersinput = sanitise($_POST["day"], 1);
  $usersinput .= "/";
  $usersinput .= sanitise($_POST["month"], 1);
  $usersinput .= "/";
  $usersinput .= sanitise($_POST["year"], 1);
  $dob = strtotime($usersinput);
  
  // Generate a nine letter password that will be emailed to the user if they requiest for it
  $password = threeLetterWord()."-".threeLetterWord()."-".threeLetterWord();

  // Salt the password
  $salt = randomStr();
  $saltedPassword = md5(md5($password.$salt));
  
  
  // Other inputs from form
  if (isset($_POST["gender"])) $gender = sanitise($_POST["gender"], 1); else $gender = "";
  if (isset($_POST["first_name"])) $first_name = sanitise($_POST["first_name"], 1); else $first_name = "";
  if (isset($_POST["parents_name"])) $parents_name = sanitise($_POST["parents_name"], 1); else $parents_name = "";
  if (isset($_POST["parents_email"])) $parents_email = sanitise($_POST["parents_email"], 1); else $parents_email = "";

  // Get the user id
  $id = $USER['id'];
  
  // Update information
  dbQuery("UPDATE users SET gender='$gender', first_name='$first_name', parents_email='$parents_email', parents_name='$parents_name', dob='$dob' 
           WHERE id=$id");
  
}

?>


