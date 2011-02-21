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
$PAGE['content'] = '
<h1>Login</h1>
<form name="login" action="?p=login" method="post">
    Username: <input type="text" name="username" />
    Password: <input type="password" name="password" />
    <input type="submit" value="Login" />
</form>
<h1>Register</h1>
<form name="register" action="?p=register" method="post">
    Username: <input type="text" name="username" maxlength="30" />
    Password: <input type="password" name="pass1" />
    Password Again: <input type="password" name="pass2" />
    <input type="submit" value="Register" />
</form>';

$PAGE['content'] .= '<br /><br />Congrats you found home... Would you like to see a <a href="?p=demoPegParse">pegParseDemo</a>?!?';

?>