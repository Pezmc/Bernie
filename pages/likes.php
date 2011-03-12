<?php

/*/          
 * pages/likes.php
 * Lists all the users likes, on a ten per page system. So they can be viewed
 *
 * Usage: Imported by index when this page is requested
 *
 * Devs: Stephen
 *
/*/

/* Rest of document just deals with displaying information not getting it */

$PAGE['title'] = "My Likes";

$PAGE['content'] = parse("MyLikes.html");

?>
