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
  
  $extra['lastThreeLiked'] = array(
  "recId1"=>"$last3Liked[0]","recImage1"=>"$row[1]","recCategory1"=>strtolower("$row[4]"),
  "recTitle1"=>$row[2],"recDisc1"=>truncate("$row[3]", 85),
  "recId2"=>"$last3Liked[0]","recImage2"=>"$row2[1]","recCategory2"=>strtolower("$row2[4]"),
  "recTitle2"=>"$row2[2]","recDisc2"=>truncate("$row2[3]", 85),
  "recId3"=>"$last3Liked[0]","recImage3"=>"$row3[1]","recCategory3"=>strtolower("$row3[4]"),
  "recTitle3"=>"$row3[2]","recDisc3"=>truncate("$row3[3]", 85));
  



	$PAGE['content'] = parse("FrontPageLoggedIn.html", $extra);
} else {
	$PAGE['content'] = parse("FrontPageLoggedOut.html", $extraContent);
}

//$PAGE['content'] .= '<br /><br />Congrats you found home... Would you like to see a <a href="?p=demoPegParse">pegParseDemo</a>?!?';

?>
