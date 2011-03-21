<?php
/* PHP to check whether the username and email the user has entered in the sign up form
 * are not already in the database.
 * If they are, a value of 0 is sent to the ajax request
 * and errors are displayed when the user presses submit.
 * 
 * Modified from the tutorial at http://web.enavu.com/tutorials/checking-username-availability-with-ajax-using-jquery/
 *
 */

// Check username availability
include_once('check_username_availability.php');

// Check email availability
include_once('check_email_availability.php');

?>
