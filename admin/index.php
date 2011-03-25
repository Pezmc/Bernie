<?php

/*/
 * admin/index.php
 * Front end for the functions Florin wrote, adds basic passowrd
 *
 * Usage: None
 *
 * Devs: Pez
/*/

/* Set Defaults */
$page['title'] = "Bernie Admin";
$page['page'] = "Login";
$page['content'] = "There is no content? Try another link!";

/* Server Password */
$global['password'] = '09fb75fec83dfc65d6d39257a4d88687';
$global['page'] = $_GET['p'];

/* Include template parsing function */
include_once('template.php');

/* Are they logged in? */
function loggedIn() {
	global $global;
	return ($_COOKIE['login'] == md5($global['password'] . $_SERVER["remote_addr"]) || md5($_POST['password']) == $global['password']); //md5 of password and ip
}

/* Trying to log in?!? */
if(!empty($_POST['login_submit'])) {
	if(md5($_POST['password']) == $global['password']) {
		setcookie('login', md5($global['password'] . $_SERVER["remote_addr"]), time()+3600*24); //expire in one day
	} else {
		$page['error'] = "<div class='error'>Password incorrect</div><br /><br />";
	}
}

/* Actual Page Display */
if(loggedIn()) {
	switch ($global['page']) {
	case 'addSuggestions':
		$page['page'] = 'Add Suggestions';
		include('addSuggestions.php');

		break; case 'viewSuggestions':
		$page['page'] = 'View Suggestions';
		include('viewSuggestions.php');

		break; case 'addTags':
		$page['page'] = 'Add Tags';
		include('addTags.php');

		break; case 'logout':
		setcookie('login', md5($global['password'] . $_SERVER["remote_addr"]), time()-(3600*24));
		$page['page'] = 'Logout';
		$page['content'] = 'Logged out';

		break; default:
		$page['content'] = '<ul><li><a href="?p=addTags"> Add Tags </a></li>';
		$page['content'] .= '<li><a href="?p=viewSuggestions"> View Suggestions </a></li>';
		$page['content'] .= '<li><a href="?p=addSuggestions"> Add Suggestions	</a></li>';
		$page['content'] .= '<li><a href="?p=logout"> Logout </a></li></ul>';
	}
} else {
	$page['content'] =  '<form action="index.php" method="post">Password: <input type="password" name="password" /><input type="submit" name="login_submit" value="Go" /></form>';
}

/* Parse and display the template */
echo parseTemplate('template.html');


?>
