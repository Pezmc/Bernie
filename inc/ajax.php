<?php

$id = $_GET['id'];
$msg = $_GET['msg'];

$justTheUser = dbQuery("SELECT * FROM user_interests WHERE user_id = '".$USER['id']."' LIMIT 1");
if(mysql_num_rows($justTheUser)<1) {
  dbQuery("INSERT INTO user_interests (`user_id`) VALUES ('".$USER['id']."')");
  $justTheUser = dbQuery("SELECT * FROM user_interests WHERE user_id = '".$USER['id']."' LIMIT 1");
}
$row = mysql_fetch_array($justTheUser);
$justTheUser = dbQuery("SELECT * FROM user_interests WHERE user_id = '".$USER['id']."' LIMIT 1");
$currentLikes = @unserialize($row['liked']);
$currentDislikes = @unserialize($row['disliked']);
if(!$currentLikes) {
  $currentLikes = array();
}
if(!$currentDislikes) {
  $currentDislikes = array();
}

if(!isset($USER['id'])) {
  die("You need to be logged in.");
}
if(empty($id)) {
  die("You didn't choose something to like");
}
if(empty($msg)) {
  die("No type set...");
}

switch($msg) {
  case "like":
    while($row = mysql_fetch_array($justTheUser)) {   
      if(!in_array($id, $currentLikes)) {
        $currentLikes[] = $id;
        $newCurrentDislikes = array();
        foreach($currentDislikes as $thisDisliked) {
          if ($thisDisliked!=$id) {
            $newCurrentDislikes[] = $thisDisliked;
          }
        }    
        $usersLikedSuggestions = serialize($currentLikes);
        $usersDislikedSuggestions = serialize($newCurrentDislikes);
        dbQuery("UPDATE user_interests SET `liked`='$usersLikedSuggestions', `disliked`='$usersDislikedSuggestions' WHERE user_id='".$USER['id']."'");
      }
    }
    break;

  case "dislike":
    while($row = mysql_fetch_array($justTheUser)) {
      if(!in_array($id, $currentLikes)) {
        $currentDislikes[] = $id;
        $newCurrentLikes = array();
        foreach($currentLikes as $thisLiked) {
          if ($thisLiked!=$id) {
            $newCurrentLikes[] = $thisLiked;
          }
        }  
        $usersLikedSuggestions = serialize($newCurrentLikes);
        $usersDislikedSuggestions = serialize($currentDislikes);
        dbQuery("UPDATE user_interests SET `liked`='$usersLikedSuggestions', `disliked`='$usersDislikedSuggestions' WHERE user_id='".$USER['id']."'");
      }
    }	  
    break;

  case "unlike":
	  $justTheUser = dbQuery("SELECT * FROM user_interests WHERE user_id = '".$USER['id']."'");
    while($row = mysql_fetch_array($justTheUser)) {
      $newCurrentLikes = array();
      foreach($currentLikes as $thisLiked) {
        if ($thisLiked!=$id) {
          $newCurrentLikes[] = $thisLiked;
        }
      }  
      $usersLikedSuggestions = serialize($newCurrentLikes);
      dbQuery("UPDATE user_interests SET `liked`='$usersLikedSuggestions' WHERE user_id='".$USER['id']."'");
    } 
    break;

  case "undislike":
    $justTheUser = dbQuery("SELECT * FROM user_interests WHERE user_id = '".$USER['id']."'");
    while($row = mysql_fetch_array($justTheUser)) {
      $newCurrentDislikes = array();
      foreach($currentDislikes as $thisLiked) {
        if ($thisLiked!=$id) {
          $newCurrentDislikes[] = $thisLiked;
        }
      }  
      $usersDislikedSuggestions = serialize($newCurrentDislikes);
      dbQuery("UPDATE user_interests SET `disliked`='$usersDislikedSuggestions' WHERE user_id='".$USER['id']."'");
    }	  
    break;
  
  default:
    echo "Error";
    break;
}







?>
