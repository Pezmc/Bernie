<?php $suggestion_id = $_GET['suggestion_id']; ?>
<html>
<head>
<title> <?php echo $suggestion_id; ?> </title>
</head>
<body>
<h3> <?php echo $suggestion_id; ?></h3>
<?php
include("dp.php");
dbQuery("SELECT * FROM comment WHERE suggestion_id='$suggestion_id' ORDER BY id DESC");
while($row = mysql_fetch_array($sql)){
?>
<table border='1'>
<tr><td><small><?php echo $row['username']; ?> said:</small><?php echo $row['content']; ?><br /><small>on: <?php echo $row['time']; ?></small></td></tr>
</table>
<?php
}
?>
<br /><br />

<form action="post.php" method="post">
<div id="comments">
 <img src="http://server.pezcuckow.com/Bernie/images/comments.png"></img>
 <br><br>
 <p> Add yours: </p>
 <p>
     <table>
        <tr><td><input type="text" class="comment" name="comment" id="comment"/></td></tr>
        <tr><td><input type="hidden" name="suggestion_id" value="<?php echo $suggestion_id;?>" /></td><tr>
        <td><input type="submit" class=medium name="submit" value="POST" id="submit"/></td></tr>   
     </table>
</p>
</div>
</form>

</body>
</html>
