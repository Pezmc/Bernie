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

// I dont know what im doing

// CODE HERE to convert users date, month and year of birth into a timestamp
$dob = 98790870; // Use random one for now

// CODE HERE to generate a nine letter password that will be emailed to the user
$password = "password"; // Use random one for now

// Other inputs from form
$gender = sanitise($_POST['gender'], 1);
$first_name = sanitise($_POST['first_name'], 1);
$username = sanitise($_POST['username'], 1);
$parents_name = sanitise($_POST['parents_name'], 1);
$parents_email = sanitise($_POST['parents_email'], 1);

// Create the user
dbQuery("INSERT INTO users (gender, first_name, username, dob, parents_name, parents_email, password) 
				 VALUES ('gender', 'first_name', 'username', 'dob', 'parents_name', 'parents_email', 'password')");

?>


