<?php

/*/          
 * Database.php
 * Provides functions to connect to previously specified database in config.php
/*/

/* Connect to the database */
	function connect_me($database=false){
    global $CONFIG, $GLOBAL;
    if($CONFIG['debug']) { 
      $CONFIG['db']['con'] = mysql_connect($CONFIG['db']['host'], $CONFIG['db']['user'], $CONFIG['db']['pass'])
                or (echo "<h3>MySQL Error</h3><br />".mysql_error()); 
    }	else {
      $GLOBAL['db']['con'] = mysql_connect($CONFIG['db']['host'], $CONFIG['db']['user'], $CONFIG['db']['pass']);
    }
		if(!empty($database)) { mysql_select_db($database); }
	}
	
/* Disconnect from database */
	function disconnect_me(){
		@mysql_close($GLOBAL['db']['con']);
		@mysql_close();
	}
	
/* Make a query on the database */
	function db_query($query=false) {
		global $admin_mysql_queries, $admin_debug, $web_folder, $admin_echo_queries;
				$admin_mysql_queries++;
		if($admin_echo_queries==1) {
			echo 'Query '.$admin_mysql_queries.': '.$query.'<br />';
		}
		if(!empty($query)) {
		if($admin_debug==1) { $str = mysql_query($query) or die(mysql_error()); } else {  $str = mysql_query($query) or(mail("errors@pegproductions.com", "MySQL Error", 'File: '.$_SERVER['PHP_SELF'].'
Error: '.mysql_error().'
Query: '.$query.'
Dump:
'.var_export(debug_backtrace(),true).'

Good luck finding the problem!

Less than happy error bot,')); }
		return($str);
		} else {
			if($admin_debug==1) die("You didn't enter a query?!?");
		}
	}
	
	function database_query($query=false) { return admin_mysql_query($query); } //Alias

?>
