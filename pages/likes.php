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
// Right erm it needs to get all the details from every like.
// so does an array need to contain all the details from every liked suggestion.
// so it can do an alternate number of dbQuerys... erm - how the fuck do I do that

  $user = dbQuery("SELECT user_id,liked FROM user_interests WHERE user_id='{$USER['id']}' LIMIT 1");
  $row = mysql_fetch_array($user);
  $likes = unserialize($row['liked']);
  $bigList = array();

  foreach($likes as $like) {
    $query = dbQuery("SELECT id,category,tags,title,author,image_med,summary,description,release_year,length FROM suggestions WHERE id='$like' LIMIT 1");
    //build array of stuff from this...
    while ($row= mysql_fetch_array($query)) {
      $row['category'] = strtolower($row['category']);
      $bigList[] = $row;
      
    }

    //then the HTML can for each loop over biglist
  }
  

//FUCK YER ADAMAMAMAMSJDJ

$extra['bigList'] = $bigList; 

$PAGE['content'] = parse("MyLikes.html", $extra);

?>
