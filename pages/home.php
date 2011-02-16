<?php

/*/          
 * pages/home.php
 * Provide the content for the home page
 *
 * Usage: Include when the home page is needed
 *
 * Devs: ??
/*/

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

?>