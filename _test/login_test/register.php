<?php
//retrieve our data from POST
$username = $_POST['username'];
$pass1 = $_POST['pass1'];
$pass2 = $_POST['pass2'];
if($pass1 != $pass2)
    header('Location: index.php');
if(strlen($username) > 30)
    header('Location: index.php');

$hash = hash('sha256', $pass);

//creates a 3 character sequence
function createSalt()
{
    $string = md5(uniqid(rand(), true));
    return substr($string, 0, 3);
}
$salt = createSalt();
$hash = hash('sha256', $salt . $hash);


$conn = mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($dbname, $conn);
//sanitize username
$username = mysql_real_escape_string($username);
$query = "INSERT INTO users ( username, password, salt )
        VALUES ( '$username' , '$hash' , '$salt' );";
mysql_query($query);
mysql_close();
header('Location: login_form.php');



?>
