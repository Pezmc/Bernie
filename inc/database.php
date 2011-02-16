<?php

/*/          
 * inc/database.php
 * Provides functions to connect to previously specified database in config.php
 *
 * Usage: Just call the functions
 *
 * Devs: Pez
 *
/*/

/* Connect to the database */
	function connectMe($database=false) {
		global $CONFIG, $GLOBAL;
		if($CONFIG['debug']) { 
		  $CONFIG['db']['con'] = mysql_connect($CONFIG['db']['host'], $CONFIG['db']['user'], $CONFIG['db']['pass']) 
		  		or (print("<h3>MySQL Error</h3><br />".mysql_error())); 
		} else {
		  $GLOBAL['db']['con'] = mysql_connect($CONFIG['db']['host'], $CONFIG['db']['user'], $CONFIG['db']['pass']);
		}
		if(!empty($database)) { mysql_select_db($database); }
	}
	
/* Disconnect from database */
	function disconnectMe() {
		global $GLOBAL;
		@mysql_close($GLOBAL['db']['con']);
		@mysql_close();
	}
	
/* Make a query on the database */
	function dbQuery($query=false) {
		global $CONFIG, $GLOBAL;
		if($config['printqueries']) {
			echo 'Query '.$admin_mysql_queries.': '.$query.'<br />';
		}
		if(!empty($query)) {
			if(!$config['debug']) {  //Debug on/off?
				//$str = mysql_query($query) or die(mysql_error()); 
				$str = mysql_query($query); 
			} else {  
				$str = mysql_query($query) or(print('<h3>MySQL Error</h3><br />'
													.'File: '.$_SERVER['PHP_SELF'].'<br />'
													.'Error: '.mysql_error().'<br />'
													.'Query: '.$query.'<br />'
													.'Dump: '.var_export(debug_backtrace(),true).'<br />'
													.'<br />Good luck finding the problem!'
													.'<br /><br />Less than happy error bot.'));
			}
			return($str); //Return the results
		} else {
			if($config['debug']) print("No query made?!?");
		}
	}
	
	function databaseQuery($query=false) { return admin_mysql_query($query); } //Alias
	
 /* Try and make user input "safer" */
	function sanitise($input, $level=0) {
		//The level specifies how much to remove
		//0 - Remove whitespace
		//1 - Real escape just makes it safe
		//2 - Converts html to things like &amp;
		//3 - Removes all html
		if(level>=0) $input = trim($input);
		if(level>=1) $input = mysql_real_escape_string($input);
		if(level>=3) $input = strip_tags($input);
		if(level>=2) $input = htmlspecialchars($input);
	}

?>
