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
// store teh query as a result variable
//$tip = "";
$extraContent = array();
$extraContent['tip'] = "";
if(mysql_num_rows($result)>0) 
{
   // output as long as rthere is still available fields we have limit 1
   while($row = mysql_fetch_row($result))
   {
      $extraContent['tip']=$row['tip'];
   }
} 
// Else do nothing
else
{
  $extraContent['tip'] = "Be nice to people";
}
if(isLoggedIn()) {
	$PAGE['content'] = parse("FrontPageLoggedIn.html");
} else {
	$PAGE['content'] = parse("FrontPageLoggedOut.html", $extraContent);
}

//$PAGE['content'] .= '<br /><br />Congrats you found home... Would you like to see a <a href="?p=demoPegParse">pegParseDemo</a>?!?';

?>
