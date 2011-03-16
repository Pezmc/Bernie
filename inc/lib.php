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
	
    elseif($_SESSION['valid'])
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
/*
getNewSuggestion($category) {

 Go through current users likes, adding every tag and every time it appears to an array 

in the user_interests in the database which record the id's of likes and id's of dislikes.

HAS TO GO THROUGH LIKES FIRST.

then dislikes removes tag id's from the array.

initial interests does something too. 

leaving us with a array of tag ids to choose a random tag id from.

for now lets just make an array with some numbers in

$likedTags = tagsArray(1,2,2,3,3,4,4,5,5,6);

$tagToBernie = tagsArray[(Math.random () * (tagsArray.length - 1))];

 $usersLikes = mysql_query(SELECT id,tags FROM suggestions WHERE category='$category');

while($row = mysql_fetch_array( $usersLikes )

if tags contains $tagToBernie 

add its id to an array

return  $tagToBernie;

}	*/

?>