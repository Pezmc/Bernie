<?php

/*/          
 * inc/getUserInfo.php
 * Grabs all the user information for the currently logged in session
 * 
 * Usage: Include this page
 *
 * Devs: Florin/Pez
 *
/*/

//Try the current user
if($results = dbQuery("SELECT * FROM users WHERE id = '".$_SESSION['userid']."'")) {
	$USER = mysql_fetch_array($results, MYSQL_ASSOC);
} else { //Weird stuff going on...
	//Force logout
	logout();
	
	//Stop the page
	die("Glitch in security");
}



?>