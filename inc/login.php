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
  $result = dbQuery("SELECT * FROM users WHERE username = '{$_POST['login_username']}' LIMIT 1");
  if (mysql_num_rows($result) == 1)
  {
    $row = mysql_fetch_array($result);
    // Hashed & Salted
    // if (md5(md5($_POST['login_passw']).$row['salt']) == $row['password'])
    // Plain
    if ($_POST['login_passw'] == $row['password'])
      validateUser($row['id']);
    else
      echo 'Error_pass';
  }
  else
    echo 'Error_user';
}

?>
