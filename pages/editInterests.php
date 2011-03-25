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
include_once('inc/editinterests.php');

/* Rest of document just deals with displaying information not getting it */

$PAGE['title'] = "Edit interests";

$PAGE['content'] = parse("EditInterests.html");



?>
