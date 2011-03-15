<?php
include_once('connect.php');

$commenting_form =  <'form name="" action="addcomment.php" method="post">
<div id="comments">
 <img src="http://server.pezcuckow.com/Bernie/images/comments.png"></img>
 <br><br>
 <p> Add yours: </p>
 <p>
     <table>
        <tr><td><input type="text" class="comment" name="msg_message" id="msg_message"/></td>
        <td><input type="submit" class=medium name="msg_submit" value="POST" id="msg_submit"/></td></tr>   
     </table>
</p>
</div>
</form>';

$get_comments = mysql_query("SELECT * FROM 'comments' ORDER BY id DESC");
$comments_count = mysql_num_rows($get_comments);

if ($comments_count > 0)
{
   while ($com = mysql_fetch_array($get_comments))
   {
      $id = $com['id'];
      $message = $com['text'];
      $comment .= .$message.;
   }
   $comment .= $commenting_form;
}
else
{
   $comment = 'There are no comments for this item at the moment.'.$commenting_form;
}

?>

<!DOCTYPE html>
<html>
<body>
<?php
   echo $comment;
?>
</body>
</html>
