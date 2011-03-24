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


$category = $GLOBAL['category'];
if(!empty($GLOBAL['id'])) {
  $suggestionID = $GLOBAL['id'];
} else {
  $suggestionID = getNewSuggestion($category);
  header("Location: ".getFullUrl()."&id=$suggestionID");
}
$altSuggestionIDs = getAltSuggestions($suggestionID);
/* $altSuggestionIDs = array(4,5,6); */


$suggestion1 = dbQuery("SELECT id,image_med,title,author,release_year,length,summary,description,url FROM suggestions WHERE id='$suggestionID'");
$row = mysql_fetch_row($suggestion1);

$suggestion2 = dbQuery("SELECT id,image_med,title,author,release_year,length,summary,description,category FROM suggestions WHERE id='$altSuggestionIDs[0]'");
$row2 = mysql_fetch_row($suggestion2);

$suggestion3 = dbQuery("SELECT id,image_med,title,author,release_year,length,summary,description,category FROM suggestions WHERE id='$altSuggestionIDs[1]'");
$row3 = mysql_fetch_row($suggestion3);

$suggestion4 = dbQuery("SELECT id,image_med,title,author,release_year,length,summary,description,category FROM suggestions WHERE id='$altSuggestionIDs[2]'");
$row4 = mysql_fetch_row($suggestion4);


$suggestion= array("sugImage"=>"$row[1]","sugTitle"=>"$row[2]","sugAuthor"=>"$row[3]",
"sugYear"=>"$row[4]","sugLength"=>"$row[5]","sugSubTitle"=>"$row[6]","sugDescription"=>"$row[7]","url"=>"$row[8]",
"altImage1"=>"$row2[1]","smallAlt1"=>strtolower("$row2[8]"),"altTitle1"=>"$row2[2]","altDisc1"=>truncate("$row2[7]", 85),
"altImage2"=>"$row3[1]","smallAlt2"=>strtolower("$row3[8]"),"altTitle2"=>"$row3[2]","altDisc2"=>truncate("$row3[7]", 85),
"altImage3"=>"$row4[1]","smallAlt3"=>strtolower("$row4[8]"),"altTitle3"=>"$row4[2]","altDisc3"=>truncate("$row4[7]", 85));

/* Pez - This could be done like

$suggestion = array();
$suggestion['sugImage'] = $row[1];
$suggestion['sugTitle'] = $row[2];
etc...
*/


/* Rest of document just deals with displaying information not getting it */

$PAGE['title'] = " has suggested you, '$row[2]'";
$PAGE['content'] = parse("Bernie.html", $suggestion);

 ?>
