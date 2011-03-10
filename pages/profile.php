<?php

/*/          
 * pages/profile.php
 * This will allow the user to change all their personal settings which they entered during step one of the sign up process
 * and allows the user to edit their interests, doing this will make new item become available to be shown when bernieing.
 *
 * Global $GLOBAL['id'] 1 is for edit profile, 2 is for edit interests
 *
 * Usage: Imported by index when this page is requested
 *
 * Devs: Florin
 *
/*/

/* Thinking Code */
include_once('inc/lib.php');

$PAGE['title'] = "Edit Profile";

$PAGE['content'] = parse("Profile.html");

/* Rest of document just deals with displaying information not getting it */

?>
