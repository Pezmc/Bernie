<?php

/*/          
 * ing/signup.php
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

// Get sanitise function
include_once('database.php');

// I dont know what im doing

// CODE HERE to convert users date, month and year of birth into a timestamp
$dob = "98790870"; // Use random one for now

// CODE HERE to generate a nine letter password that will be emailed to the user
$password = "randompass"; // Use random one for now

// Other inputs from form
if (isset($_POST['gender'])) {$gender = sanitise($_POST['gender'], 1);} else $gender = "";
if (isset($_POST['first_name'])) $first_name = sanitise($_POST['first_name'], 1); else $first_name = "";
if (isset($_POST['username'])) $username = sanitise($_POST['username'], 1); else $username = "";
if (isset($_POST['parents_name'])) $parents_name = sanitise($_POST['parents_name'], 1); else $parents_name = "";
if (isset($_POST['parents_email'])) $parents_email = sanitise($_POST['parents_email'], 1); else $parents_email = "";

echo "Gender: ".$gender;

// Create the user
dbQuery("INSERT INTO users (gender, first_name, username, dob, parents_name, parents_email, password) 
				 VALUES ('.$gender.', '.$first_name.', '.$username.', '$dob', '.$parents_name.', '.$parents_email.', '.$password.')");

?>


