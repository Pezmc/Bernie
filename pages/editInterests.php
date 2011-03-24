<?php

global $USER;
	
	$id = $USER['id'];
  $query = dbQuery("SELECT tags FROM user_interests WHERE user_id = '$id'");
  $likedInterests = array();
 
  while($row = mysql_fetch_array($query)) {
	  $likedInterests = unserialize($row['tags']);  
	}
	
	if (!$likedInterests)
    $likedInterests = array();

$GLOBAL['liked_interests'] = $likedInterests;
 
  //$liked = array();
  //$liked['likedInterests'] = $likedInterests;

$PAGE['content'] = parse("includes/EditInterests.html", $liked);
?>
