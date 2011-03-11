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

$PAGE['title'] = "Bernie";

$suggestion= array("sugImage"=>"http://cvcl.mit.edu/hybrid/cat2.jpg","Cat"=>"_","sugTitle"=>"The cat book",
"sugAuthor"=>"Cat writer","sugYear"=>"1990","sugLength"=>"Long","sugSubTitle"=>"cat the cat cat is a cat which shat", "sugDescription"=>"cattycattycatty","altImage1"=>"http://www.cats.org.uk/images/cat_silhouette_news.jpg","smallAlt1"=>"https://github.com/Pezmc/Bernie/raw/master/old/Original%20Files/icon_books_small.png","altTitle1"=>"more cats","altDisc1"=>"oh they are so fluffy","altImage2"=>"http://www.cats.org.uk/images/cat_silhouette_news.jpg","smallAlt2"=>"https://github.com/Pezmc/Bernie/raw/master/old/Original%20Files/icon_books_small.png","altTitle2"=>"more cats","altDisc2"=>"oh they are so fluffy",("altImage3"=>"http://www.cats.org.uk/images/cat_silhouette_news.jpg","smallAlt3"=>"https://github.com/Pezmc/Bernie/raw/master/old/Original%20Files/icon_books_small.png","altTitle3"=>"more cats","altDisc3"=>"oh they are so fluffy");

$altSuggestion1=array("altImage1"=>"http://www.cats.org.uk/images/cat_silhouette_news.jpg","smallAlt1"=>"https://github.com/Pezmc/Bernie/raw/master/old/Original%20Files/icon_books_small.png","altTitle1"=>"more cats","altDisc1"=>"oh they are so fluffy",);

$altSuggestion2=array("altImage2"=>"http://www.cats.org.uk/images/cat_silhouette_news.jpg","smallAlt2"=>"https://github.com/Pezmc/Bernie/raw/master/old/Original%20Files/icon_books_small.png","altTitle2"=>"more cats","altDisc2"=>"oh they are so fluffy");

$altSuggestion3=array("altImage3"=>"http://www.cats.org.uk/images/cat_silhouette_news.jpg","smallAlt3"=>"https://github.com/Pezmc/Bernie/raw/master/old/Original%20Files/icon_books_small.png","altTitle3"=>"more cats","altDisc3"=>"oh they are so fluffy");


$PAGE['content'] = parse("Bernie.html", $suggestion);






/* Rest of document just deals with displaying information not getting it */
?>
