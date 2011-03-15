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

include_once('database.php');

// Do I need to connect to the database? 
// I know it already does in index.php but i can reduce the number of errors if i do connect
// connectMe('11_COMP10120_D1');

// CODE HERE to convert users date, month and year of birth into a timestamp
$dob = 98790870; // Use random one for now

// CODE HERE to generate a nine letter password that will be emailed to the user
$password = "password"; // Use random one for now

// Other inputs from form
$gender = $_POST['gender'];
$first_name = $_POST['first_name'];
$username = $_POST['username'];
$parents_name = $_POST['parents_name'];
$parents_email = $_POST['parents_email'];

// Create the user
dbQuery("INSERT INTO users (gender, first_name, username, dob, parents_name, parents_email, password) 
				 VALUES (gender, first_name, username, dob, parents_name, parents_email, password)");

?>


