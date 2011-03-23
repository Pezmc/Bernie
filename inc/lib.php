<?php

/*/          
 * inc/lib.php
 * A library file to store shared function that more than one part of the website
 * can use. If a function is needed in more than one place it really should be here
 *
 * Usage: See each function
 *
 * Devs: Everyone
 *
/*/

/* Takes input and makes it cleaner */
function tidy($input, $level = 0) {
	//Level dictates how much is changed
	//0 - Delete whitespace
	//1 - Convert & to &amp; etc
	//2 - Make all lowercase
	if($level>=0) $input = trim($input);
	if($level>=1) $input = htmlspecialchars($input);
	if($level>=2) $input = strtolower($input);
	return $input;	
}

/*
 * Shortens given text and adds ... 
 * Modified from: http://www.the-art-of-web.com/php/truncate/
 */
function truncate($string, $limit, $break=" ", $pad="...") {

  // Return with no change if string is shorter than $limit
  if(strlen($string) <= $limit) return $string;

  // is $break present between $limit and the end of the string?
  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
    if($breakpoint < strlen($string) - 1) {
      $string = substr($string, 0, $breakpoint) . $pad;
    }
  }
    
  return $string;
}

/*
 * Return random letters
 */
function randomStr($length = 3) {
    $string = md5(uniqid(rand(), true));
    return substr($string, 0, $length);
}

/*
 * Grant a user website access, you MUST set the ID
 */
function validateUser($id) {
	if(empty($id)) die("You started a session without an ID...");
    session_regenerate_id (); //this is a security measure
    $_SESSION['valid'] = 1;
    $_SESSION['userid'] = $id;
}

/*
 * Is a user logged in?
 */
function isLoggedIn() {
	if(empty($_SESSION['valid'])) return false;
	
    elseif($_SESSION['valid']==1)
        return true;

    return false;
}

/*
 * Log a user out (from the system)
 */
function logout() {
    $_SESSION = array(); //destroy all of the session variables
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}

/*
 * Is the current user a boy?
 */
function isBoy() {
	global $USER;
	if(!isset($USER['gender'])) return true; //If we don't know guess they are
    if($USER['gender']=="m") {
		return true;
	} else {
		return false;
	}
}

/*
 * Is the current user a boy?
 */
function isGirl() {
	global $USER;
	if(!isset($USER['gender'])) return false; //If we don't know guess they aren't
    if($USER['gender']=="f") {
		return true;
	} else {
		return false;
	}
}

/*
 * Is the current user a boy?
 */
function isGenderUnknown() {
	global $USER;
	if(!isset($USER['gender'])) return true; //If we don't know guess they aren't
    if($USER['gender']=="u") {
		return true;
	} else {
		return false;
	}
}

/*
 * Returns the dir of the currently running file... here becaue Soba sucks
 */
function getCurrentDirectory() {
	$path = dirname($_SERVER['PHP_SELF']);
	$position = strrpos($path,'/') + 1;
	return substr($path,$position);
}

/*
 * Gets and returns the day of birth of the user from the timestamp
 */
function getDayOfBirth() {
        global $USER;
	$dayOfBirth = date("d", $USER['dob']);
	return $dayOfBirth;
}

/*
 * Gets and returns the month of birth of the user from the timestamp
 */
function getMonthOfBirth() {
        global $USER;
	$monthOfBirth = date("m", $USER['dob']);
	return $monthOfBirth;
}

/*
 * Gets and returns the year of birth of the user from the timestamp
 */
function getYearOfBirth() {
        global $USER;
	$yearOfBirth = date("Y", $USER['dob']);
	return $yearOfBirth;
}

/*
 * Returns true if the given category is currently open
 */
function isOpen($cat) {
        global $GLOBAL;
	if($GLOBAL['category']==$cat) {
		return true;
	} else {
		return false;
	}
}

function isDisliked() {
    global $USER, $GLOBAL;
    $id = $GLOBAL['id'];
    $justTheUser = dbQuery("SELECT * FROM user_interests WHERE user_id ='".$USER['id']."'");
    /* $justTheUser = dbQuery("SELECT * FROM user_interests WHERE user_id ='$USER['id']'");*/
    while($row = mysql_fetch_array($justTheUser)) {
      $currentDislikes = @unserialize($row['disliked']);   
			if(!$currentDislikes) {
		    $currentDislikes = array();
      }
      foreach($currentDislikes as $thisDisliked) {
        if ($thisDisliked==$id)
          return true;
       }
     }
     return false;
      
}


function isLiked() {       
    global $USER, $GLOBAL;
    $id = $GLOBAL['id'];
    $justTheUser = dbQuery("SELECT * FROM user_interests WHERE user_id = '".$USER['id']."'");
    while($row = mysql_fetch_array($justTheUser)) {
      $currentLikes = @unserialize($row['liked']);   
			if(!$currentLikes) {
		    $currentLikes = array();
      }
     foreach($currentLikes as $thisLiked) {
        if ($thisLiked==$id)
          return true;
      }
    }
    return false;
      
}

function randCat() {
        $randomC = rand(1, 4);
        switch ($randomC) 
        {
        case 1:
             return "?p=bernie&c=books";
             break;
        case 2:
             return "?p=bernie&c=tv";
             break;
        case 3:
             return "?p=bernie&c=music";
             break;
        case 4:
              return "?p=bernie&c=web";
              break;
        default:
             return "?p=bernie&c=books";
        }
}

/* Generate a three letter word in the format consonant-vowel-consonant */
function threeLetterWord() {
	$consonants = array("b", "c", "d", "f", "g", "h", "j", "k", "l", "m", "n", "p", "q", "r", "s", "t", "v", "w", "x", "y", "z");
	$vowels = array('a', 'e', 'i', 'o', 'u');
	$str = $consonants[array_rand($consonants)].$vowels[array_rand($vowels)].$consonants[array_rand($consonants)];
	$badWords = array("bum", "tit", "cum", "dic", "dik", "pot", "fap", "fat", "coc", "cok", "jew",
	                  "fuk", "fuc", "jiz", "fag", "git", "nut", "vag", "sex", "nob", "cox", "kok", "gay", "sob", "sux");
	if (in_array($str, $badWords)) {
    $str = threeLetterWord();
	}
	return $str;
}

/* Given the category needed, this function returns a new suggestion ID */
function getNewSuggestion($category) { /*

Go through current users likes, adding every tag and every time it appears to an array 

in the user_interests in the database which record the id's of likes and id's of dislikes. 

It creats an array called likedTags. then goes through the users database.

finds users row and gets all that shit

for every liked "tag" add that X ammount of times to the likedTags array

for every liked suggestion, extract the tags from that suggestion, and adds the tags to the likedTags array

for every disliked suggestion, extract the tags from that suggestion, and for every tag, go through the likedTags array until it finds an occurance of that tag, if it does, it removes that []entry from the
array */
	
	// The user is needed so we know which id to get from the first dbQuery
	global $USER;
	
	// Returns from the user interests database our users row.
	$thisUsersLikes = dbQuery("SELECT * FROM user_interests WHERE user_id='".$USER['id']."'");
	
	// gets all the suggestions.
	$allSuggestions = dbQuery("SELECT id,tags FROM suggestions");
	
	//creates an empty array which is edited three times. the code does work so far unless this is populated before
	$likedTags = array(1,2,4);
	
	// In order to know which suggestions to not suggest (if they've already been rated before).
	$alreadyRatedSuggestions = array();
	// This while loop only happens once.
        while($row = mysql_fetch_array($thisUsersLikes)) {
	
		/* The tags, liked suggestion and disliked suggestions are taken from the users interests,
		if they cant be found ( the column was empty in the database) it just creates an empty array instead. */
		$initialTags = @unserialize($row['tags']);
		$likedSuggestions = @unserialize($row['liked']);
		$dislikedSuggestions = @unserialize($row['disliked']);
		if(!$initialTags) {
		    $initialTags = array();
		}
		if(!$likedSuggestions) {
		    $likedSuggestions = array();
		}    
		if(!$dislikedSuggestions) {
		    $dislikedSuggestions = array();
		}
		
		// The first loop which populates the likedTags array
		// for every tag inside initial tags
		foreach($initialTags as $thisID) {
		  //Adds the id of this tag X times to the liked tags ( $times is the 'weighting')
		  for ($times=1; $times<=3; $times++)
 		 {
 		   $likedTags[] = $thisID;
 		 }		
		}  
		  
		// The second loop which populates the likedTags array
		// every tag inside every suggestion that is liked
		foreach($likedSuggestions as $thisID) { 
		  //marks the tags id as already rated
		  $alreadyRatedSuggestions[] = $thisID;
		  // for every suggestion
		  while($row2 = mysql_fetch_array($allSuggestions)) {	
		    
		    if ($row2['id'] == $thisID ) {
		    $suggestionID = 1;
	return $suggestionID;
		      $theTagsOfThisSuggestion = @unserialize($row2['tags']);
		      if(!$theTagsOfThisSuggestion) {
	                $theTagsOfThisSuggestion = array();
	       	        }
		      foreach($theTagsOfThisSuggestion as $aLikedTag) {
		        $likedTags[] = $aLikedTag;
						 
		      }
		    }
		  }
		}
		// At this point we have an array filled with every tag from every suggestion they like. 
		  
		foreach($dislikedSuggestions as $thisID) { 
		$alreadyRatedSuggestions[] = $thisID;
		  while($row2 = mysql_fetch_array($allSuggestions)) {		
		    if ($row2['id'] == $thisID ) {
		      $theUnTagsOfThisSuggestion = @unserialize($row2['tags']);
		      if(!$theUnTagsOfThisSuggestion) {
		        $theUnTagsOfThisSuggestion = array();
		      } 
		      foreach($theUnTagsOfThisSuggestion as $aDislikedTag) {
	                $removeThisTag = array_search($aDislikedTag, $likedTags);
			if (!$removeThisTag) {}
			else {
			  unset($likedTags[$removeThisTag]);			   
		        } //else
		      } // foreach
		    } // if
		  } // while
		}  // foreach
	} //  while

		// At this point for every tag in disliked suggestions is removed once from likedTags.
		// And we have an array containing our "likedTags"
	
        $potentialSuggestions = array();
	$i=0;
	$z=0;
	
	do {
		$chosenTag = $likedTags[array_rand($likedTags)];

		
    
    while($row = mysql_fetch_array($allSuggestions))
		if ($row['category'] == $category) {
			$abc = @unserialize($row['tags']);	
			if(!$abc) {
		          $abc = array();
			}
			foreach($abc as $someTag) {		
				if ($someTag==$chosenTag) {                		
					$potentialSuggestions[$i] = $row['id'];				
					$i+= 1;
				}
			}
		}
		$z++;
	}
	while (sizeof($potentialSuggestions)==0&&$z<50);
	
	if($z>=50) {
	 $suggestion = dbQuery("SELECT id,tags,category FROM suggestions WHERE category ='$category' ORDER BY rand() LIMIT 1");
      // $suggestion = dbQuery("SELECT id,tags FROM suggestions WHERE ORDER BY rand() LIMIT 1");
    $row = mysql_fetch_array($suggestion);
    $potentialSuggestions[$i] = $row['id'];	
	}
	
	$notSeenPotentialSuggestions = array();	
	foreach($potentialSuggestions as $aPotentialSuggestion) {
	  $removeThisSuggestion = array_search($aPotentialSuggestion, $alreadyRatedSuggestions);
	  if (!$removeThisSuggestion) {
	    $notSeenPotentialSuggestions[] = $aPotentialSuggestion;
	  }
	}
	if (sizeof($notSeenPotentialSuggestions)==0) {
	  $suggestionID = $potentialSuggestions[array_rand($potentialSuggestions)];
	}
	else {
	  $suggestionID = $notSeenPotentialSuggestions[array_rand($notSeenPotentialSuggestions)];	
	}
	return $suggestionID;	
}


function getAltSuggestions($mainSuggestionID) { 	
  $mainSuggestion = dbQuery("SELECT tags FROM suggestions WHERE id='$mainSuggestionID' LIMIT 1");
  $potentialSuggestions = array();  
	
	while($row = mysql_fetch_array($mainSuggestion)) {
		$mainTags = @unserialize($row['tags']);
  }
	
	$i = 0;	
	$z = 0;
  $allSuggestions = dbQuery("SELECT id,tags FROM suggestions WHERE `id` != '$mainSuggestionID'");	
  do {
		
    foreach($mainTags as $chosenTag) {
      //$chosenTag = $mainTags[array_rand($mainTags)];
		  //echo $chosenTag;

		  

		  while($row = mysql_fetch_array($allSuggestions))
		  {
			  $abc = @unserialize($row['tags']);	
			  if(!$abc) {
		      $abc = array();
			  }
			  foreach($abc as $someTag) {		
				  if ($someTag==$chosenTag) {                       		
					  $potentialSuggestions[$i] = $row['id'];				
					  $i+= 1;
				  }
			  }
		  }
      
		$z++;
    }
	}
	while (sizeof($potentialSuggestions) < 3&&$z<20);
	
	if(sizeof($potentialSuggestions)<3) {
	   //echo "I cheated";
     $allSuggestions = dbQuery("SELECT id FROM suggestions ORDER BY rand() LIMIT 3");
     
     $potentialSuggestions = array();
     while($row = mysql_fetch_array($allSuggestions,MYSQL_ASSOC)) {
        $potentialSuggestions[] = $row['id'];
     }
	}
			
	shuffle($potentialSuggestions);
	$suggestionID = array_splice($potentialSuggestions, 0, 3);
		
	//print_r($suggestionID);
	return $suggestionID;	
}

/* Get the FULL URL - http://www.phpro.org/examples/Get-Full-URL.html */
 function getFullUrl() {
    /*** check for https ***/    /*** return the full address ***/
    return 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
 }

/*
 * Returns true if the user is on the given signup step
 */
function isOnStep($step) {
        global $GLOBAL;
	if($GLOBAL['id']==$step)
		return true;
}

/*
 * Return an array with all of the tags in the database
 */
function getTagArray() {
// Get the number of tags currently listed in the database
  $result = dbQuery("SELECT tag,id FROM tags");
	$theTags = array();
	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$theTags[] = $row;
	}

	return $theTags;
}

/*
 * Return an array with all of the tags in the database
 */
/*function getTagArray() {
// Get the number of tags currently listed in the database
  $result = dbQuery("SELECT tag,id FROM tags");
	$theTags = array();
	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$theTags[] = $row;
	}

	return $theTags;
}*/

/*
 * Validate an email address
 */
function validEmail($email) {
  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return true;
	} else {
		return false;
	}
  return true;
}

/*
 * Validate a timestamp
 * Modified from tutorial on http://stackoverflow.com/questions/2524680/check-whether-the-string-is-a-unix-timestamp
 * This does not guarantee a valid date, just the format of the timestamp
 */
function isValidTimeStamp($timestamp)
{
    return ((string) (int) $timestamp === $timestamp) 
        && ($timestamp <= PHP_INT_MAX)
        && ($timestamp >= ~PHP_INT_MAX);
}

/*
 * Returns true if the global contains the given string 
 */
function errorLocation($string) {
        global $PAGE;
	if($PAGE['error_location']==$string) {
		return true;
	} else {
		return false;
	}
}

?>
