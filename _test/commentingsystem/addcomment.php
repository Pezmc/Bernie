<?php
include_once(" connect.php");

$msg_title = $_POST['msg_title'];
$msg_message = $_POST['msg_message']; 
$msg_submit = $_POST['msg_submit'];
if ($msg_submit&&$msg_title&&$msg_message)
{
     mysql_query("INSERT INTO comments VALUES (''.'".$msg_title."'.'".$msg_message."')");
}
     header("Location: commentingsystem/");
?>
