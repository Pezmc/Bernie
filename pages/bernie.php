<?php

/*/          
 * pages/bernie.php
 * When one of the four individual icons buttons are pressed the system will loop through that category and find one that matches the users interests. 
 * It will not be one that has previously been liked or disliked (unless there are no more that haven't been liked of disliked in which case it will 
 * randomly choose one of the already liked items). Then it will randomly choose 3 more items with matching or similar tags to the 'feature' item.
 *
 * If a category is set it only uses that category, else chooses one at random
 *
 * Usage: Imported by index when this page is requested
 *
 * Devs: Adam
 *
/*/


/* Thinking Code */

include_once('inc/lib.php');

$PAGE['title'] = "Bernie";

$suggestion= array("sugImage"=>"http://cvcl.mit.edu/hybrid/cat2.jpg","Cat"=>"_","sugAuthor"=>"Cat writer","sugYear"=>"1990","sugLength"=>"Long","sugSubTItle"=>"cat the cat cat is a cat which shat","sugDescription"=>"cattycattycatty",");


$PAGE['content'] = parse("Bernie.html");






/* Rest of document just deals with displaying information not getting it */
?>
