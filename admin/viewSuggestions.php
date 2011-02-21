<?php

/*/          
 * admin/viewSuggestions.php
 * Query the suggestions database for all the data it has
 *
 * Usage: Simply view the file and echo $page['content']
 *
 * Devs: Florin, Pez
/*/

/* Buffer the page */
ob_start();

function Truncate($string, $limit, $break=" ", $pad="...")
{
  // return with no change if string is shorter than $limit
  if(strlen($string) <= $limit) return $string;

  // is $break present between $limit and the end of the string?
  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
    if($breakpoint < strlen($string) - 1) {
      $string = substr($string, 0, $breakpoint) . $pad;
    }
  }
    
  return $string;
}

// Connect to the database
$connection = mysql_connect("ramen.cs.man.ac.uk", "11_COMP10120_D1", "ztDsBWSMqDny80BR") or die("Could not connect: " . mysql_error());
mysql_select_db("11_COMP10120_D1", $connection) or die("Could not select database");

$result = mysql_query("SELECT * FROM `tags`") or die("Could not retrieve tags");
while($row = mysql_fetch_array($result))
  $tags[$row['id']] = $row['tag'];

		?><table><tr><td>id</td><td>image</td><td>category</td><td>tags</td><td>age</td><td>title</td><td>author</td><td>gender</td><td>weighting</td><td>summary</td><td>description</td><td>created_date</td><td>created_by</td><td>likes</td><td>dislikes</td><td>length</td><td>url</td><td>release_year</td></tr>
        <?php
		$result = mysql_query("SELECT * FROM `suggestions` ORDER BY id DESC") or die("Could not retrieve suggestions");
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
		  <td>'.$row['weighting'].'</td><td>'.Truncate($row['summary'],50,' ','...').'</td>
		  <td>'.Truncate($row['description'],100,' ','..').'</td><td>'.$row['created_date'].'</td>
		  <td>'.$row['created_by'].'</td><td>'.$row['likes'].'</td><td>'.$row['dislikes'].'</td>
		  <td>'.$row['length'].'</td><td>'.$row['url'].'</td><td>'.$row['release_year'].'</td></tr>';
		  // Space for otputing and formatting the result.
		}
		?></table><?php

mysql_close($connection);

/* Set the contents of the page & don't output */
$page['content'] = ob_get_contents();
ob_end_clean();
 
?>