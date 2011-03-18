<?php

$id = $_GET['id'];
$id = $_GET['msg'];
global $USER;

primt_r($USER);

switch($_GET['msg']) {
  case "like":
	  $justTheUser = dbQuery("SELECT * FROM user_interests WHERE user_id = '".$USER['id']."'");
    while($row = mysql_fetch_array($justTheUser)) {
      $currentLikes = @unserialize($row['liked']);
      $currentDislikes = @unserialize($row['disliked']);
		  	if(!$currentLikes) {
		      $currentLikes = array();
        }
        if(!$currentDislikes) {
		      $currentDislikes = array();
        }
      $currentLikes[] = '$id';
      foreach($currentDislikes as $thisDisliked) {
        if ($thisDisliked==$id)
          unset($currentDislikes[$thisDisliked]);
      }    
      $usersLikedSuggestions = serialize($currentLikes);
      $usersDislikedSuggestions = serialize($currentDislikes);
      mysql_query("INSERT INTO 'user_interests' ('liked','disliked')
      VALUES ('$usersLikedSuggestions','$usersDislikedSuggestions')");
    }
    break;

  case "dislike":
    $justTheUser = dbQuery("SELECT * FROM user_interests WHERE user_id = '".$USER['id']."'");
    while($row = mysql_fetch_array($justTheUser)) {
     $currentLikes = @unserialize($row['liked']);
     $currentDislikes = @unserialize($row['disliked']);
		  	if(!$currentLikes) {
		      $currentLikes = array();
       }
       if(!$currentDislikes) {
		      $currentDislikes = array();
       }
     $currentDislikes[] = '$id';
     foreach($currentLikes as $thisLiked) {
       if ($thisLiked==$id)
         unset($currentLikes[$thisLiked]); 
     }   
     $usersLikedSuggestions = serialize($currentLikes);
     $usersDislikedSuggestions = serialize($currentDislikes);
     mysql_query("INSERT INTO 'user_interests' ('liked','disliked')
     VALUES ('$usersLikedSuggestions','$usersDislikedSuggestions')");
    }	  
    break;

  case "unlike":
	  $justTheUser = dbQuery("SELECT * FROM user_interests WHERE user_id = '".$USER['id']."'");
    while($row = mysql_fetch_array($justTheUser)) {
      $currentLikes = @unserialize($row['liked']);   
			  if(!$currentLikes) {
		      $currentLikes = array();
        }
      foreach($currentLikes as $thisLiked) {
        if ($thisLiked==$id)
          unset($currentLikes[$thisLiked]);    
        $usersLikedSuggestions = serialize($currentLikes);    
        mysql_query("INSERT INTO 'user_interests' ('liked')
          VALUES ('$usersLikedSuggestions')");	 
      }
    } 
    break;

  case "undislike":
    $justTheUser = dbQuery("SELECT * FROM user_interests WHERE user_id = '".$USER['id']."'");
    while($row = mysql_fetch_array($justTheUser)) {
      $currentDislikes = @unserialize($row['disliked']);   
			  if(!$currentDislikes) {
		      $currentDislikes = array();
        }
      foreach($currentDislikes as $thisDisliked) {
        if ($thisDisliked==$id)
          unset($currentDislikes[$thisDisliked]);    
      $usersDislikedSuggestions = serialize($currentDislikes);    
      mysql_query("INSERT INTO 'user_interests' ('disliked')
      VALUES ('$usersDislikedSuggestions')");
    }	  
    }
    break;
  
  default:
    echo "Error";
    break;
}







?>
