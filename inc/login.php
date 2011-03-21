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
  $result = dbQuery("SELECT * FROM users WHERE username = '{$_POST['login_username']}'");
  if (mysql_num_rows($result) == 1)
  {
    $row = mysql_fetch_array($result);
    if (md5($row['salt'].md5($_POST['login_passw'])) == $row['password'])
      header('Location: ?p=home');
    else
      echo 'Error_pass';
  }
  else
    echo 'Error_user';
}

?>
