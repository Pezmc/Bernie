<?php

/*/          
 * inc/login.php
 * System processes logging in and out, should redirect to home everytime
 *
 * Usage: Included on every page
 *
 * Devs: Florin
 *
/*/

/* See the LIB for three LOGIN/LOGOUT related functions */

if (!empty($_POST))
{
  $username = sanitise($_POST['login_username'], 1);
  $result = dbQuery("SELECT * FROM users WHERE username = '$username' LIMIT 1");
  if (mysql_num_rows($result) == 1)
  {
    $row = mysql_fetch_array($result);
    if($row['active']==1) {
		  	// Hashed & Salted
		  if (md5(md5($_POST['login_passw']).$row['salt']) == $row['password']) {
				// Plain
				//if ($_POST['login_passw'] == $row['password'])
				  validateUser($row['id']);
				  header("Location: /Bernie/?p=home");
		  } else {
		    $PAGE['error_id'] = 3;
		    include_once("pages/home.php");
		  }  
		} else {
			$PAGE['error_id'] = 2;
			include_once("pages/home.php");
		}
  }
  else {
    $PAGE['error_id'] = 1;
    include_once("pages/home.php");
  }
}

?>
