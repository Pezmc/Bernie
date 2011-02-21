<?php

/*/          
 * admin/template.php
 * Rediculously basic template parser for the admin panel
 * is mainly for referance and proof of theory
 *
 * Usage: Include this file and call parseTemplate(file.html) with $page defined
 *
 * Devs: Pez
/*/

/* Parse the given template file */
function parseTemplate($templateFile) 
{ 
  $searchPattern          = "/\{([a-zA-Z0-9_]+)\}/i"; // macro delimiter "{" and "}" 
  $replacementFunction    = "parseText";  //Method callbacks are performed this way 
  $fileData               = file_get_contents($templateFile);                        
  $parsedTemplate         = preg_replace_callback($searchPattern, $replacementFunction, $fileData); 
  
  return $parsedTemplate; 
} 

/* Replace the matches with data from $page */
function parseText($matches) { 
  global $page;
  if(isset($page[$matches[1]]))  { 
	 return $page[$matches[1]]; 
  } 
  //return '{'.$matches[1].'}';
  return '<!--'.$matches[1].'-->';
} 

?>