<?php

/*/          
 * inc/lostPassword.php
 *
 * Devs: Florin
 *
/*/

if (!empty($_POST))
{
  $email = sanitise($_POST['email'], 1);
  $result = dbQuery("SELECT id FROM users WHERE parents_email = '$email' LIMIT 1");
  if (mysql_num_rows($result) == 1)
  {
    $row = mysql_fetch_array($result);
    $randomKey = md5(rand());
    dbQuery("UPDATE users SET password = '$randomKey' WHERE id = '{$row['id']}'");
    mail($email, 'Bernie - Lost Password', "http://server.pezcuckow.com/Bernie/?p=lostpassword&key=$randomKey");
  }
  else 
    $error = 'email not found';
}
elseif (isset($_GET['key']))
{
  $key = sanitise($_GET['key']);
  $result = dbQuery("SELECT id FROM users WHERE password = '$key' LIMIT 1");
  if (mysql_num_rows($result) == 1)
  {
    $password = threeLetterWord()."-".threeLetterWord()."-".threeLetterWord();
    $salt = randomStr(3);
    $saltPassword = md5(md5($password).$salt);
    dbQuery("UPDATE users SET password = '$saltPassword' WHERE password = '$key'");
    echo $password;
  }
  else
    $error = 'go away';
}

