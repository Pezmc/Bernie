<?php

/*/          
 * pages/logout.php
 * See login.php
 *
 * Usage: Imported by index when this page is requested
 *
 * Devs: Florin
 *
/*/

/* Thinking Code */


//Log them out and then send them home
logout();
header('Location: ?p=home');

?>
