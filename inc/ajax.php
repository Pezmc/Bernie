<?php

$id = $_GET['id'];
$id = $_GET['msg'];
global $USER;

switch($_GET['msg']) {
  case "like":
	  $justTheUser = dbQuery("Select * FROM user_interests WHERE id = '$USER['id']'");
    while($row = mysql_fetch_array($justTheUser)
    $currentLikes = @unserialize($row['liked']);
    $currentDislikes = @unserialize($row['disliked']);
			if(!$currentLikes {
		    $currentLikes = array();
      }
      if(!$currentDislikes {
		    $currentDislikes = array();
      }
    $currentLikes[] = '$id';
    for(each($currentDislikes as $thisDisliked) {
      if ($thisDisliked==$id)
        unset($currentDislikes[$thisDisliked]);    
    $usersLikedSuggestions = serialize($currentLikes);
    $usersDislikedSuggestions = serialize($currentDislikes);
    mysql_query("INSERT INTO 'user_interests' ('liked','disliked')
    VALUES ('$usersLikedSuggestions','$usersDislikedSuggestions')");
    break;

  case "dislike":
    $justTheUser = dbQuery("Select * FROM user_interests WHERE id = '$USER['id']'");
    while($row = mysql_fetch_array($justTheUser)
    $currentLikes = @unserialize($row['liked']);
    $currentDislikes = @unserialize($row['disliked']);
			if(!$currentLikes {
		    $currentLikes = array();
      }
      if(!$currentDislikes {
		    $currentDislikes = array();
      }
    $currentDislikes[] = '$id';
    for(each($currentLikes as $thisLiked) {
      if ($thisLiked==$id)
        unset($currentLikes[$thisLiked]);    
    $usersLikedSuggestions = serialize($currentLikes);
    $usersDislikedSuggestions = serialize($currentDislikes);
    mysql_query("INSERT INTO 'user_interests' ('liked','disliked')
    VALUES ('$usersLikedSuggestions','$usersDislikedSuggestions')");	  
    break;

  case "unlike":
	  $justTheUser = dbQuery("Select * FROM user_interests WHERE id = '$USER['id']'");
    while($row = mysql_fetch_array($justTheUser)
    $currentLikes = @unserialize($row['liked']);   
			if(!$currentLikes {
		    $currentLikes = array();
      }
    for(each($currentLikes as $thisLiked) {
      if ($thisLiked==$id)
        unset($currentLikes[$thisLiked]);    
    $usersLikedSuggestions = serialize($currentLikes);    
    mysql_query("INSERT INTO 'user_interests' ('liked')
    VALUES ('$usersLikedSuggestions')");	  
    break;

  case "undislike"
    $justTheUser = dbQuery("Select * FROM user_interests WHERE id = '$USER['id']'");
    while($row = mysql_fetch_array($justTheUser)
    $currentDislikes = @unserialize($row['disliked']);   
			if(!$currentDislikes {
		    $currentDislikes = array();
      }
    for(each($currentDislikes as $thisDisliked) {
      if ($thisDisliked==$id)
        unset($currentDislikes[$thisDisliked]);    
    $usersDislikedSuggestions = serialize($currentDislikes);    
    mysql_query("INSERT INTO 'user_interests' ('disliked')
    VALUES ('$usersDislikedSuggestions')");	  
    break;
    
	  break;
  default:
    echo "Error";
    break;
}







?>
