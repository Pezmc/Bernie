<?php
// SQL query
dbQuery(SELECT * FROM tip ORDER BY RAND() LIMIT 1*);
// store teh query as a result variable
$result = mysql_query($dbQuery);
if(mysql_num_rows($result))
{
   // output as long as rthere is still available fields
   while($row = mysql_fetch_row($result))
   {
      echo ("<a href=\"$row[2]">$row[3]</a>");
      echo (": $row[4]<br>";
   }
}
// if no fields
else
{
   echo "no values in the database";
}

?>

