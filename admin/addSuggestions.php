<?php

// Connect to the database
$connection = mysql_connect("ramen.cs.man.ac.uk", "11_COMP10120_D1", "ztDsBWSMqDny80BR") or die("Could not connect: " . mysql_error());
mysql_select_db("11_COMP10120_D1", $connection) or die("Could not select database");

$result = mysql_query("SELECT * FROM `tags`") or die("Could not retrieve tags");
while($row = mysql_fetch_array($result))
  $tags[$row['id']] = $row['tag'];

if (!isset($_POST['upload'])) 
{

?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
Category: 
<select name="category">
  <option value="Books">Books</option>
  <option value="Music">Music</option>
  <option value="Film">Film</option>
  <option value="Website">Website</option>
</select>
<br />
Tags: 
<div style="width: 300px;">
<?php
foreach ($tags as $tagid => $tag)
{
?>
  <input type="checkbox" name="tags[]" value="<?php echo $tagid; ?>" /><?php echo $tag; ?>
<?php
}
?>
</div>
Age: 
<input type="text" name="age" />
<br />
Title:
<input type="text" name="title" />
<br />
Author:
<input type="text" name="author" />
<br />
Gender:
<input type="radius" name="gender" value="male"  />
Male
<input type="radius" name="gender" value="female" />
Female
<input type="radius" name="gender" value="other" />
Other
<br />
Image upload:
<input type="file" name="image" />
<br />
Summary:
<textarea name="summary"></textarea>
<br />
Description:
<textarea name="description"></textarea>
<br />
Created by:
<select name="created_by">
  <option value="Florin">Florin</option>
</select>
<br />
Length:
<select name="length">
  <option value="tiny">tiny</option>
  <option value="short">short</option>
  <option value="medium">medium</option>
  <option value="long">long</option>
  <option value="huge">huge</option>
</select>
<br />
URL:
<input type="text" name="url" />
<br />
Release year:
<input type="text" name="release_year" />
<br />
<input type="submit" name="upload" />

<?php

} 
else
{
  $image = "/images/" . $_FILES['image']['name'];
  
  mysql_query("INSERT INTO `suggestions` VALUES (
                                                 '{$_POST['category']}', '{$_POST['tags']}', '{$_POST['age']}', '{$_POST['title']}', '{$_POST['author']}', 
                                                 '{$_POST['gender']}', 'image', '', '{$_POST['summary']}', '{$_POST['description']}', '{$_SERVER['REQUEST_TIME']}', 
                                                 '{$_POST['created_by']}', '', '', '{$_POST['length']}', '{$_POST['url']}','{$_POST['release_year']}'
                                                ") or die("Could not add suggestion");
  
  copy($_FILES['image']['tmp_name'], $image);
  
  echo "Thank you for adding your suggestion!";  
}

mysql_close($connection);


//_close($connection);

?> 

