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
$USER['id'] = (isset($_SESSION['userid']) ? $_SESSION['userid'] : 0); 
if($results = dbQuery("SELECT * FROM users WHERE id = '".$USER['id']."'")) {
        if(mysql_num_rows($results)>0)
          $USER = mysql_fetch_array($results, MYSQL_ASSOC);
        else {
          logout();
	  header("Location: index.php");
        }
} else {  //Weird stuff going on...
	//Force logout
	logout();
	
	//Stop the page
	die("Glitch in security");
}

?>
