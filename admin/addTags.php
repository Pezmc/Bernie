<?php

// Connect to the database
$connection = mysql_connect("ramen.cs.man.ac.uk", "11_COMP10120_D1", "ztDsBWSMqDny80BR") or die("Could not connect: " . mysql_error());
mysql_select_db("11_COMP10120_D1", $connection) or die("Could not select database");

if (isset($_POST['addTag']))
{
  mysql_query("INSERT INTO `tags` VALUES ('', '{$_POST['tag']}', 1)") or die("Could not add tag");
  echo $_POST['tag'] . " has been added to the tags list.";
}
else
{

?>

<form method="post" action="">
<input type="text" name="tag" />
<input type="submit" name="addTag" value="Add tag!" />
</form>

<?php

}

mysql_close($connection);

?>