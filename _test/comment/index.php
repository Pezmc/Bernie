<?php
require('connect.php');
$name=$_POST('name');
$comment=$_POST('comment');
$submit=$_POST('submit');

if($submit)
{
	if($name&&$comment)
	{
		$insert=mysql_query("INSERT INTO comment (name,comment) VALUES ('$name','$comment')");
	}
	else
	{
		echo "Please fill out all fields";
	}
}
?>

<html>

<head>

<title>Comment Box</title>

</head>

<body>

<form action="index.php" method="POST".
<table>

<tr><td>Name: </td><td><input type="text" name="name" /></td></tr>
<tr><td colspan="2">Comment: </td></tr>
<tr><td colspan="2"><textarea name="comment"></textarea></td></tr>
<tr><td colspan="2"><input type="submit" name="submit" value="Comment" /></td></tr>


</table>


</body>
</html>
