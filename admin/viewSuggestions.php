<h1>View Suggestions</h1>
<?php

ini_set('display_errors', 1); 
ini_set('log_errors', 1); 
ini_set('error_log', dirname(__FILE__) . '/error_log.txt'); 
error_reporting(E_ALL);

// Connect to the database
$connection = mysql_connect("ramen.cs.man.ac.uk", "11_COMP10120_D1", "ztDsBWSMqDny80BR") or die("Could not connect: " . mysql_error());
mysql_select_db("11_COMP10120_D1", $connection) or die("Could not select database");

$result = mysql_query("SELECT * FROM `suggestions`") or die("Could not retrieve tags");
while ($row = mysql_fetch_array($result))
{
  echo $row['category'] . "etc...";
  // Space for otputing and formatting the result.
}

mysql_close($connection);

?>
<a href="index.php">Back</a>
