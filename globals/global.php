<?php

/*/          
 * globals/global.php
 * Creates an empty shell for global variables used for the bernie system
 * is mainly for referance and defaults, if your php stores something that
 * may be needed somewhere else, it should be a global!
 *
 * The template parses all globals, configs and page globals.
 *
 * Usage: Create default values here, change and access them from everywhere
 *
 * Devs: Everyone
 *
/*/

/* Database */
$GLOBAL['db']['con'] = null; //Current Connection
$GLOBAL['db']['queries'] = 0; //Total queries so far

/* Page Requested */
$GLOBAL['page'] = tidy((isset($_GET['p']) ? $_GET['p'] : ""),2);
$GLOBAL['catagory'] = tidy((isset($_GET['c']) ? $_GET['c'] : ""),2);
$GLOBAL['id'] = tidy((isset($_GET['id']) ? $_GET['id'] : ""),2);

?>
