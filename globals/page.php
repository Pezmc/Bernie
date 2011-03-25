<?php

/*/          
 * globals/page.php
 * Creates an empty shell for page variables used for the bernie system
 * when parsing the template, everything that is displayed should go through here
 *
 * The template parses all globals, configs and page globals.
 *
 * Usage: Create default values here, change and access them from everywhere, parse in the template
 *
 * Devs: Everyone
 *
/*/

$PAGE['title'] = 'Home';
$PAGE['subtitle'] = 'Hmm..';
$PAGE['content'] = '';
$PAGE['footer'] = '&copy; D1 - University of Manchester / d1@lists.pezcuckow.com / By using this website you agree not to sue us';
$PAGE['error_message'] = "";
$PAGE['confirmation_message'] = "";
$PAGE['error_id'] = 0;
$PAGE['error_location'] = array(""); // used in the signup form 
$PAGE['system_info'] = "";

$PAGE['chosen_interests'] = array(""); // used when editing interests

?>
