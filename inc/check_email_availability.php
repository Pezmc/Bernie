<?php
/* PHP to check whether the email the user has entered in the sign up form
 * is not already in the database.
 * If is is, a value of 0 is sent to the ajax request
 * and errors are displayed when the user presses submit.
 * 
 * Modified from the tutorial at http://web.enavu.com/tutorials/checking-username-availability-with-ajax-using-jquery/
 *
 */

// Get the email that the user has entered in the form
$parents_email = mysql_real_escape_string($_POST['parents_email']);  
  
// Query the database to find a field that has the same value username as $username
$result = mysql_query('SELECT parents_email FROM users WHERE parents_email = "'. $parents_email .'"');  
  
// We use a function to find how many rows correspond to $result
// If there exists at least one, that means that the username is already taken
if(mysql_num_rows($result)>0) { echo 0; } // We send 0 to the Ajax request
else { echo 1; } // Username available, we send 1 to the Ajax request

?>
