<?php


/*/          
 * admin/index.php
 * Front end for the functions Florin wrote, adds basic passowrd
 *
 * Usage: Include this file to set the page variables
 *
 * Devs: Florin, Pez
/*/

//Include Database Settings
include_once("../inc/database.php");
include_once("../config.php");
include_once("../inc/lib.php");

// Connect to the database
$connection = connectMe("11_COMP10120_D1");

$result = mysql_query("SELECT * FROM `tags`") or die("Could not retrieve tags");
while($row = mysql_fetch_array($result))
  $tags[$row['id']] = $row['tag'];

/* Buffer the page */
ob_start();

if (!isset($_POST['upload'])) 
{

?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=addSuggestions" method="post" enctype="multipart/form-data">
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
<select name="gender">
  <option value="male">Male</option>
  <option value="female">Female</option>
  <option value="other">Other</option>
</select>
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
  <option value="Adam">Adam</option>
  <option value="Pez">Pez</option>
  <option value="Elise">Elise</option>
  <option value="Niki">Niki</option>
  <option value="Stephen">Stephen</option> 
</select>
<br />
Length:
<select name="length">
  <option value="tiny">Tiny</option>
  <option value="short">Short</option>
  <option value="medium">Medium</option>
  <option value="long">Long</option>
  <option value="huge">Huge</option>
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

	$dir = "../".$CONFIG['imagedir']. sanitise(str_replace(" ",'',$_POST['category']),3) . "/" . sanitise(str_replace(" ",'',$_POST['author']),3) . "/";
	$target_image = $dir . str_replace(" ", "_", sanitise($_POST['title'],3).'_'.substr(md5(time()), 0, 3).'.jpg');
	if (!is_dir ($dir)) { 
		mkdir($dir, 0777, true); 
	}
	$file_info = getimagesize($_FILES['image']['tmp_name']);
	if(!($file_info['mime']=="image/jpeg"||$file_info['mime']=="image/jpg")||!move_uploaded_file($_FILES['image']['tmp_name'], $target_image)) {
		echo "There was an error uploading the file, please try again! Is it a jpeg?<br /><br />I think it is a ".$file_info['mime'];
		
	} else {
		include('SimpleImage.php');
		$image = new SimpleImage();
		$image->load($target_image);
		$image->resizeToWidth(190);
		$image->save(substr($target_image,0,-4).'_med.jpg');
		$image->crop(59,59);
		$image->save(substr($target_image,0,-4).'_thumb.jpg');
		
		echo "The file ".  basename( $_FILES['image']['name'])." has been uploaded";
		
		foreach ($_POST['tags'] as $tag) {
			$post_tags[] = $tag;
		}
	
		$time = date('Y-m-d H:i:s');
		$post_tags_text = serialize($post_tags);
		
		$_POST['category'] = sanitise($_POST['category']);
		$_POST['age'] = sanitise($_POST['age']);
		$_POST['title'] = sanitise($_POST['title']);
		$_POST['author'] = sanitise($_POST['author']);
		$_POST['gender'] = sanitise($_POST['gender']);
		$_POST['summary'] = sanitise($_POST['summary']);
		$_POST['description'] = sanitise($_POST['description']);
		$_POST['created_by'] = sanitise($_POST['created_by']);
		$_POST['length'] = sanitise($_POST['length']);
		$_POST['url'] = sanitise($_POST['url']);
		$_POST['release_year'] = sanitise($_POST['release_year']);
	
  		mysql_query("INSERT INTO `suggestions` (
				`category`,
				`tags` ,
				`age` ,
				`title` ,
				`author` ,
				`gender` ,
				`image` ,
				`image_med` ,
				`image_thumb` ,
				`summary` ,
				`description` ,
				`created_date` ,
				`created_by` ,
				`length` ,
				`url` ,
				`release_year`
			) VALUES (
                 '{$_POST['category']}',
				 '{$post_tags_text}',
				 '{$_POST['age']}',
				 '{$_POST['title']}',
				 '{$_POST['author']}', 
                 '{$_POST['gender']}',
				 '{$target_image}',
				 '".substr($target_image,0,-4).'_med.jpg'."',
				 '".substr($target_image,0,-4).'_thumb.jpg'."',
				 '{$_POST['summary']}',
				 '{$_POST['description']}',
				 '{$time}',
				 '{$_POST['created_by']}',
				 '{$_POST['length']}',
				 '{$_POST['url']}',
				 '{$_POST['release_year']}'
			)") or die("Could not add suggestion: ".mysql_error());											
  
		echo "<br />Thank you for adding your suggestion!<br /><br />";
		//$extra_query = " ORDER BY id LIMIT 1";
		//include("viewSuggestions.php");  ?>
		<table><tr><td>id</td><td>image</td><td>category</td><td>tags</td><td>age</td><td>title</td><td>author</td><td>gender</td><td>weighting</td><td>summary</td><td>description</td><td>created_date</td><td>created_by</td><td>likes</td><td>dislikes</td><td>length</td><td>url</td><td>release_year</td></tr>
        <?php
		$result = mysql_query("SELECT * FROM `suggestions` ORDER BY id DESC LIMIT 1") or die("Could not retrieve suggestions");
		while ($row = mysql_fetch_array($result))
		{
		  echo '<tr><td>'.$row['id'].'</td><td><img src="'.$row['image_thumb'].'" /></td>
		  <td>'.$row['category'].'</td><td>';
		  $tag_list = unserialize($row['tags']);
		  foreach ($tag_list as $tag) {
			  echo $tags[$tag].', ';
		  }
		  echo '</td><td>'.$row['age'].'</td>
		  <td>'.$row['title'].'</td><td>'.$row['author'].'</td><td>'.$row['gender'].'</td>
		  <td>'.$row['weighting'].'</td><td>'.truncate($row['summary'],50,' ','...').'</td>
		  <td>'.truncate($row['description'],100,' ','..').'</td><td>'.$row['created_date'].'</td>
		  <td>'.$row['created_by'].'</td><td>'.$row['likes'].'</td><td>'.$row['dislikes'].'</td>
		  <td>'.$row['length'].'</td><td>'.$row['url'].'</td><td>'.$row['release_year'].'</td></tr>';
		  // Space for otputing and formatting the result.
		}
		?></table><?php
	}
}

disconnectMe();


/* Set the contents of the page & don't output */
$page['content'] = ob_get_contents();
ob_end_clean();

?> 