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


$suggestion1 = dbQuery("SELECT id,image_med,title,author,release_year,length,summary,description,url FROM suggestions WHERE id='$suggestionID'");
$row = mysql_fetch_row($suggestion1);

$suggestion2 = dbQuery("SELECT id,image_thumb,title,author,release_year,length,summary,description,category FROM suggestions WHERE id='$altSuggestionIDs[0]'");
$row2 = mysql_fetch_row($suggestion2);

$suggestion3 = dbQuery("SELECT id,image_thumb,title,author,release_year,length,summary,description,category FROM suggestions WHERE id='$altSuggestionIDs[1]'");
$row3 = mysql_fetch_row($suggestion3);

$suggestion4 = dbQuery("SELECT id,image_thumb,title,author,release_year,length,summary,description,category FROM suggestions WHERE id='$altSuggestionIDs[2]'");
$row4 = mysql_fetch_row($suggestion4);


$suggestion= array("sugId"=>"$suggestionID","sugImage"=>"$row[1]","sugTitle"=>"$row[2]","sugAuthor"=>"$row[3]",
"sugYear"=>"$row[4]","sugLength"=>"$row[5]","sugSubTitle"=>"$row[6]","sugDescription"=>"$row[7]","url"=>"$row[8]",
"altSugId1"=>"$altSuggestionIDs[0]","altImage1"=>"$row2[1]","altCategory1"=>strtolower("$row2[8]"),"altTitle1"=>"$row2[2]","altDisc1"=>truncate("$row2[7]", 85),
"altSugId2"=>"$altSuggestionIDs[1]","altImage2"=>"$row3[1]","altCategory2"=>strtolower("$row3[8]"),"altTitle2"=>"$row3[2]","altDisc2"=>truncate("$row3[7]", 85),
"altSugId3"=>"$altSuggestionIDs[2]","altImage3"=>"$row4[1]","altCategory3"=>strtolower("$row4[8]"),"altTitle3"=>"$row4[2]","altDisc3"=>truncate("$row4[7]", 85));

/////////////COMMMENTNSMNTS////////////////////
if(isset($_POST['comment'])&&isset($_POST['suggestion_id'])) {


	$comment = sanitise($_POST['comment'],1);
	$suggestion_id  = sanitise($_POST['suggestion_id'],1);
	$time = date("m/d/Y");
	
	$comment = mysql_real_escape_string($comment);
	$suggestion_id = mysql_real_escape_string($suggestion_id);
	
	$sql = dbQuery("INSERT INTO comments (`suggestion_id`, `username`, `content`, `time`) VALUES ('$suggestion_id', '{$USER['username']}', '$comment', '$time')");
}


$suggestion['comments'] = array();

$sql = dbQuery("SELECT * FROM comments WHERE suggestion_id='$suggestionID' ORDER BY id DESC");
if(mysql_num_rows($sql)>0) {
	while($row = mysql_fetch_array($sql)){
		$suggestion['comments'][] = array("username"=>$row['username'], "content"=>$row['content'], "time"=>$row['time']);
	}
}

/* Pez - This could be done like

$suggestion = array();
$suggestion['sugImage'] = $row[1];
$suggestion['sugTitle'] = $row[2];
etc...
*/


/* Rest of document just deals with displaying information not getting it */

$PAGE['title'] = " has suggested you, '$row[2]'";
$PAGE['content'] = parse("Bernietest.html", $suggestion);

 ?>
