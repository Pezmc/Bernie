<?php

/*/          
 * pages/home.php
 * Either displays logged in or logged out home page
 *
 * Includes the tip of the day, recent likes, current interests etc...
 *
 * Usage: Include when the home page is needed
 *
 * Devs: Pez
/*/

/* Thinking Code */
include_once('inc/home.php');

/* Rest of document just deals with displaying information not getting it */

$PAGE['title'] = "Home";

// TIP OF THE DAY

// SQL query
$result = dbQuery("SELECT * FROM tip ORDER BY RAND() LIMIT 1");
$extraContent = array();
// store teh query as a result variable
//$tip = "";
$extraContent['tip'] = "";
if(mysql_num_rows($result)>0) 
{
   // output as long as rthere is still available fields we have limit 1
   while($row = mysql_fetch_array($result))
   {
      $tip=$row['tip'];
      $extraContent['tip']=$row['tip'];
   }
} 
// Else do nothing
else
{
  $extraContent['tip'] = "Be nice to people";
}
// I think this does the same thing with less lines
/* $theTipToGive = dbQuery("SELECT tip FROM tip ORDER BY rand() LIMIT 1");
$row = mysql_fetch_row($theTipToGive);
$extraContent = array("tip"=>"row[0]");
*/

if(isLoggedIn()) {
  // get the interests
  $extra = array();
  $extra['interests'] = giveInterests();
  // also needs to get the last three liked suggestions
  $last3Liked = getLast3Liked();
  $firstQuery = dbQuery("SELECT id,image_thumb,title,description,category FROM suggestions WHERE id='$last3Liked[0]'");
  $row = mysql_fetch_row($firstQuery);

  $secondQuery = dbQuery("SELECT id,image_thumb,title,description,category FROM suggestions WHERE id='$last3Liked[1]'");
  $row2 = mysql_fetch_row($secondQuery);

  $thirdQuery = dbQuery("SELECT id,image_thumb,title,description,category FROM suggestions WHERE id='$last3Liked[2]'");
  $row3 = mysql_fetch_row($thirdQuery);
  
  $lastThreeLiked = array(
  "altSugId1"=>"$last3Liked[0]","altImage1"=>"$row[1]","category1"=>strtolower("$row[4]"),
  "altTitle1"=>"$row[2]","altDisc1"=>truncate("$row[3]", 85),
  "altSugId1"=>"$last3Liked[0]","altImage1"=>"$row[1]","category1"=>strtolower("$row[4]"),
  "altTitle1"=>"$row[2]","altDisc1"=>truncate("$row[3]", 85),
  "altSugId1"=>"$last3Liked[0]","altImage1"=>"$row[1]","category1"=>strtolower("$row[4]"),
  "altTitle1"=>"$row[2]","altDisc1"=>truncate("$row[3]", 85));

	$PAGE['content'] = parse("FrontPageLoggedIn.html", $extra, $lastThreeLiked);
} else {
	$PAGE['content'] = parse("FrontPageLoggedOut.html", $extraContent);
}

//$PAGE['content'] .= '<br /><br />Congrats you found home... Would you like to see a <a href="?p=demoPegParse">pegParseDemo</a>?!?';

?>
