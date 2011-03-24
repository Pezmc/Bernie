<?php

/*/          
 * pages/lostPassword.php
 * When the lost password item is clicked, a new randomly generated password will be sent to their parents account.
 * Similar to the one sent during the registration process.
 *
 * Usage: Imported by index when this page is requested
 *
 * Devs: Adam
 *
/*/

/* Thinking Code */
include_once('inc/lostPassword.php');

/* Rest of document just deals with displaying information not getting it */

$PAGE['title'] = "Lost password";

$PAGE['content'] .= parse('LostPassword.html');


?>
