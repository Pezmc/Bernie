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

/* Show us errors */
ini_set('display_errors', 1); 
ini_set('log_errors', 0); 
error_reporting(E_STRICT);
ini_set('mysql.connect_timeout', 10);

/* Allow tracking sessions (logins) */
session_start();

/* Include our systems main parts, these are just varibles and functions */
include_once('config.php');
include_once('inc/database.php');
include_once('inc/lib.php');
include_once('globals/global.php');
include_once('globals/page.php');
include_once('globals/user.php');
include_once('inc/parse.php');

/* Template parse, in case someone needs it */
include_once('inc/pegParse.class.php');

/* Database */
connectMe('11_COMP10120_D1'); //We always need a database connection

/* If the user isn't logged in yet */
if(!isLoggedIn()) {
	//If they are trying to access something they are not allowed to
	switch($GLOBAL['page']) {
		case "login":
		case "signup":
		case "lostpassword":
		case "demopegparse":
		case "ajaxusername":
		case "ajaxemail":
		case "lostpassword":
		case "confirmation":
		break;
		default:
			$GLOBAL['page']="home"; //Send them home	
		break;
	}

	if($GLOBAL['page']=="ajaxusername") {
	  include_once("inc/check_username_availability.php");
    die();
	} elseif($GLOBAL['page']=="ajaxemail") {
	  include_once("inc/check_email_availability.php");
    die();
	}
} else { //They are logged in
	//Lets grab that users information
	include_once("inc/getUserInfo.php");
	if($GLOBAL['page']=="ajax") {
	  include_once("inc/ajax.php");
    die();
	}
}

/* What page has the user requested? */
switch ($GLOBAL['page']) {
	case "bernie": include_once('pages/bernie.php'); break;	
	case "login": include_once('pages/login.php'); break;	
	case "logout": include_once('pages/logout.php'); break;	
	case "likes": include_once('pages/likes.php'); break;
	case "profile": include_once('pages/profile.php'); break;	
	case "lostpassword": include_once('pages/lostPassword.php'); break;
	case "signup": include_once('pages/signup.php'); break;
  case "editinterests": include_once('pages/editInterests.php'); break;
  case "confirmation": include_once('pages/confirmation.php'); break;
	case "demopegparse": include_once('pages/demoPegParse.php'); break;
	default: include_once('pages/home.php'); break;
}

/* Database */
disconnectMe(); //Last thing we do is close the DB

/* Parse Template Here */
//include_once("inc/htmLawed.php");
//$out = htmLawed(parse('master.html'), array('tidy'=>'    ')); 
//echo $out;
echo parse('master.html');

/* Short and sweet :-) */

?>
