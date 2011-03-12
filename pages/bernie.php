<?php

/*/          
 * pages/bernie.php
 * When one of the four individual icons buttons are pressed the system will loop through that category and find one that matches the users interests. 
 * It will not be one that has previously been liked or disliked (unless there are no more that haven't been liked of disliked in which case it will 
 * randomly choose one of the already liked items). Then it will randomly choose 3 more items with matching or similar tags to the 'feature' item.
 *
 * If a category is set it only uses that category, else chooses one at random
 *
 * Usage: Imported by index when this page is requested
 *
 * Devs: Adam
 *
/*/


/* Thinking Code */

include_once('inc/lib.php');
/* include_once("inc/database.php"); /*
/* $connection = connectMe("11_COMP10120_D1"); */

/* Go through current users likes, adding every tag and every time it appears to an array */
/* Random number from 0 to 1, times the number of items in this array  --> to give the tag which is going to be bernied */
/* For this tag, go through suggestions and add the id off all which contain this tag to an array */
/* Random number from 0 to 1, times the number of items in this array --> gives the id of the suggestion which is the result */

/* change the content of the suggestion array to contain details this. */
/* SELECT tags FROM suggestions */

$connection = mysql_connect("ramen.cs.man.ac.uk", "11_COMP10120_D1", "ztDsBWSMqDny80BR")
    or die('Could not connect: ' . mysql_error());
mysql_select_db("11_COMP10120_D1", $connection)
    or die('Could not select database'); 
/* Main suggestion is i, f g h are alternate suggestions */

$i=1;
$f=1;
$g=3;
$h=4;

$suggestion1 = mysql_query("SELECT id,image_med,title,author,release_year,length,summary,description FROM suggestions WHERE id = '$i'");
$row = mysql_fetch_row($suggestion1);

$suggestion2 = mysql_query("SELECT id,image_med,title,author,release_year,length,summary,description,category FROM suggestions WHERE id = '$f'");
$row2 = mysql_fetch_row($suggestion2);

$suggestion3 = mysql_query("SELECT id,image_med,title,author,release_year,length,summary,description,category FROM suggestions WHERE id = '$g'");
$row3 = mysql_fetch_row($suggestion3);

$suggestion4 = mysql_query("SELECT id,image_med,title,author,release_year,length,summary,description,category FROM suggestions WHERE id = '$h'");
$row4 = mysql_fetch_row($suggestion4);




$suggestion= array("sugImage"=>"$row[1]","sugTitle"=>"$row[2]",
"sugAuthor"=>"$row[3]","sugYear"=>"$row[4]","sugLength"=>"$row[5]","sugSubTitle"=>"$row[6]",
"sugDescription"=>"$row[7]","altImage1"=>"$row2[1]","smallAlt1"=>"$row2[8]","altTitle1"=>"$row2[2]","altDisc1"=>truncate("$row2[7]", 100),
"altImage2"=>"$row3[1]","smallAlt2"=>"$row3[8]",
"altTitle2"=>"$row3[2]","altDisc2"=>"$row3[7]",
"altImage3"=>"$row4[1]","smallAlt3"=>"$row4[8]",
"altTitle3"=>"$row4[2]","altDisc3"=>"$row4[7]");


/* $suggestion= array("sugImage"=>"http://cvcl.mit.edu/hybrid/cat2.jpg","Cat"=>"_","sugTitle"=>"The cat book",
"sugAuthor"=>"Cat writer","sugYear"=>"1990","sugLength"=>"Long","sugSubTitle"=>"cat the cat cat is a cat which shat","sugDescription"=>"cattycattycatty","altImage1"=>"http://www.cats.org.uk/images/cat_silhouette_news.jpg","smallAlt1"=>"https://github.com/Pezmc/Bernie/raw/master/old/Original%20Files/icon_books_small.png","altTitle1"=>"more cats","altDisc1"=>"oh they are so fluffy","altImage2"=>"http://www.cats.org.uk/images/cat_silhouette_news.jpg","smallAlt2"=>"https://github.com/Pezmc/Bernie/raw/master/old/Original%20Files/icon_books_small.png","altTitle2"=>"more cats","altDisc2"=>"oh they are so fluffy","altImage3"=>"http://www.cats.org.uk/images/cat_silhouette_news.jpg","smallAlt3"=>"https://github.com/Pezmc/Bernie/raw/master/old/Original%20Files/icon_books_small.png","altTitle3"=>"more cats","altDisc3"=>"oh they are so fluffy"); */





/* Rest of document just deals with displaying information not getting it */

$PAGE['title'] = "Bernie";
$PAGE['content'] = parse("Bernie.html", $suggestion);

 ?>
