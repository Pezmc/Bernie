<?php

/*/          
 * inc/global.php
 * Creates an empty shell for global variables used for the bernie system
 * is mainly for referance and defaults, if your php stores something that
 * may be needed somewhere else, it should be a global!
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
$GLOBAL['page'] = tidy($_GET['p']);
$GLOBAL['catagory'] = tidy($_GET['c']);
$GLOBAL['id'] = tidy($_GET['id']);

?>
