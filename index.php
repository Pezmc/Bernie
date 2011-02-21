<?php

/*/          
 * index.php
 * Bernie the suggestion engine for your kids, this is the file
 * that the website is run through, in theory this should do as little
 * as possible, the less it has to do the faster the site
 *
 * Usage: N/a
 *
 * Devs: Pez, Elise, Florin, Niki, Stephen, Adam
 *
/*/

/* ===== God like code from here on in ===== */

/* Include our systems main parts, these are just varibles and functions */
include_once('config.php');
include_once('inc/lib.php');
include_once('globals/global.php');
include_once('globals/page.php');
include_once('inc/database.php');
include_once('inc/parse.php');

/* Template parse, in case someone needs it */
include_once('inc/PegParse.class.php');

/* Database */
connectMe('11_COMP10120_D1'); //We always need a database connection

/* What page has the user requested? */
switch ($GLOBAL['page']) {
	case "bernie": break;	
	case "login": break;	
	case "logout": break;	
	case "likes": break;
	case "profile": break;	
	case "signup": break;
	case "demoPegParse": include_once('pages/demoPegParse.php'); break;
	default: include_once('pages/home.php'); break;
}

/* Database */
disconnectMe(); //Last thing we do is close the DB

/* Parse Template Here */
echo parse('master.html');

/* Short and sweet :-) */

?>
