<?php

$connection = mysql_connect("ramen.cs.man.ac.uk", "11_COMP10120_D1", "ztDsBWSMqDny80BR")
    or die('Could not connect:' .my_sql_error());
mysql_select_db("11_COMP10120_D1",$connection)
    or die('Could not select database');

?>
