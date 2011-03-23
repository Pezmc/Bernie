
<table>
       <tr>
              <td width="50%" style="vertical-align:top">
<?php
$id = $USER('id');
$interests = array("");
$query = dbQuery("SELECT tags FROM user_interests WHERE user_id =
'$id'");
while($row = mysql_fetch_array($query)) {
 $interests .= $row['tags'];
}//while
for($i = 0; $i < sizeof($interests); $i++) {
 while($interests[$i] < (sizeof($interests) / 2)) {
   echo "<li> $interests[$i]";
}//while
}//for
?>
</td>

<td width="50%" style="vertical-align:top">
<?php
for($i = 0; $i < sizeof($interests); $i++) {
 while($interests[$i] >= (sizeof($interests) / 2)) {
   echo "<li> $interests[$i]";
}//while
}//for
?>
</td>
</tr>
</table>
