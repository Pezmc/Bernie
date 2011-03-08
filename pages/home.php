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

$PAGE['title'] = "Bernie Home";
$PAGE['subtitle'] = "Login/Register";

//This is just for demo purposes atm - should be from database
$extraContent = array();
switch (round(rand(1,3))) {
	case 1: $extraContent['tip'] = "Don't stab people"; break;
	case 2: $extraContent['tip'] = "Brush your teeth before bedtime!"; break;
	case 3: $extraContent['tip'] = "Drugs are bad!"; break;
	default: $extraContent['tip'] = "Be nice to everyone!"; break;
}

if(isLoggedIn()) {
	$PAGE['content'] = parse("FrontPageLoggedIn.html");
} else {
	$PAGE['content'] = parse("FrontPageLoggedOut.html", $extraContent);
}

$PAGE['content'] .= '<br /><br />Congrats you found home... Would you like to see a <a href="?p=demoPegParse">pegParseDemo</a>?!?';

?>
