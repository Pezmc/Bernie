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
	if(level>=0) $input = trim($input);
	if(level>=1) $input = htmlspecialchars($input);
	if(level>=2) $input = strtolower($input);
	return $input;	
}

?>
