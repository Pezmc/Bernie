<?php

include("dp.php");


$comment = $_POST['comment'];
$suggestion_id  = $_POST['suggestion_id'];
$time = time("m/d/Y");

$comment = mysql_real_escape_string($comment);
$suggestion_id = mysql_real_escape_string($suggestion_id);

$sql = mysql_query("INSERT INTO comment ("suggestion_id", "username", "content", "time") VALUES ('$suggestion_id', '$username', '$content', '$time')");

if($sql)
{
echo "Comment was posted!";
}
else
{
echo "Comment was not posted!";
}

echo "<br /><a href='index.php?suggestion_id=".$suggestion_id."'>Back</a>";
?>
