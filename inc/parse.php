<?php

/*/          
 * inc/parse.php
 * Set up the parsing class, pass the globals etc to it.
 * Awaits being told which page to call.
 *
 * Usage: Not really used
 *
 * Devs: Pez
 *
/*/

function parse($template) {
	global $CONFIG, $GLOBAL, $PAGE, $USER;
	
	/* Create new instance, set up vars */
	$t = new pegParse();
	$t->config("rootDir", $_SERVER['DOCUMENT_ROOT']."/Bernie/");
	$t->config("templateDir", "templates/");
	$t->config("compileDir", "tmp/");
	
	/* Include out globals, but in case of overlaps, in a certain order */
	$t->assign($CONFIG);
	$t->assign($GLOBAL);
	$t->assign($PAGE);
	$t->assign($USER);
	
	/* How does the engine know which page we're on?!? */
	return $t->output($template);
}
?>