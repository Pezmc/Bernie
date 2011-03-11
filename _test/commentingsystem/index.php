hgfhfg	
<?php
include_once("../connect.php");
$commenting_form = '<form action = "addcomment.php" method = "post">
   <table width = "310" border = "0" cellspacing = "0" cellpadding = "0">
      <tr>
        <td colspan = "2"><strong>Add Comment:</Strong></td>
      </tr>
        <tr>
          <td width = "105">Title:</td>
          <td width = "205"><input type="text" name="msg_title" id="msg_title style=width:200px;" /></td>
        </tr>
        <tr>
          <td colspan = "2"><textarea name="msg_message" id="msg_message" style="width:100;height:200px;font-family:Courier New"> 
          Message</textarea></td>
        </tr>
        <tr>
          <td colspan = "2" align = "center"><input type="submit" value="Add Comment" name="msg_submit" id="msg_submit" /></td>
        </tr>
    </table>
    </from>';
$get_comments = mysql_query("SELECT * FROM 'comments' ORDER BY id DESC");
$comments_count = mysql_num_rows($get_comments);
if ($comments_count > 0)
{
   while ($com = mysql_fetch_array($get_comments))
   {
      $id = $com['id'];
      $title = $com['text'];
      $message = $com['message'];
      $commment .= '<b>'.$title.'</b><br />'.$message.'<hr />';
   }
   $comment .= $commenting_form;
   $page_title = $comments_count.'Comments';
}
else
{
   $comment = 'There are no comments at the moment.<br />'.commenting_form;
   $page_title = 'No Comments';
}
?>

<!DOCTYPE html>
<html>
<head>
   <title><?php echo $page_title; ?></title>
</head>
<body>
   <?php
   echo $comment;
   ?>
</body>
</html>
