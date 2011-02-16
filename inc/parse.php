<?php

/*/          
 * inc/parse.php
 * Parse a provided html file with $PAGE, $GLOBAL & $CONFIG
 *
 * Usage: Include this file and call parseTemplate(file.html) with $PAGE, $GLOBAL & $CONFIG defined
 *
 * Devs: Pez
/*/

/* Parse the given template file */
function parseTemplate($templateFile) { 
	$searchPattern          = "/\{([a-zA-Z0-9_]+)\}/i"; // macro delimiter "{" and "}" 
	$replacementFunction    = "parseText";  //Method callbacks are performed this way 
	$fileData               = file_get_contents($templateFile);                        
	$parsedTemplate         = preg_replace_callback($searchPattern, $replacementFunction, $fileData); 
  
	return $parsedTemplate; 
} 

/* Replace the matches with data from $page */
function parseText($matches) { 
  global $PAGE, $CONFIG;
  if(isset($PAGE[$matches[1]]))  { 
	 return $PAGE[$matches[1]]; 
  } elseif(isset($CONFIG[$matches[1]]))  { 
	 return $CONFIG[$matches[1]]; 
  } 
  //return '{'.$matches[1].'}';
  return '<!--'.$matches[1].'-->';
} 

//$array = "";
/* Replace the matches with data from $page */
/*function parseText($matches) { 
	global $page, $array;
	
	print_r($matches);
  
 	if(!(strpos($matches[1], "LOOP:") === false)) {
		if(isset($page[substr($matches[1],5,-1)]))  { 
			$array = $page[substr($matches[1],5,-1)];
		}
  	} elseif(!(strpos($matches[1], "ENDLOOP:") === false)) {
	  	$array = null;
	} elseif(isset($page[$matches[1]]))  { 
		if(!empty($array)) {
			return $array[$matches[1]];
		} else {
			return $page[$matches[1]]; 
		}
  	} 
  	//return '{'.$matches[1].'}';
  	return '<!--'.$matches[1].'-->';
}*/
/*
function parseTemplate($file) {
  global $PAGE, $CONFIG;
  $searchPattern          = "/\{([a-zA-Z0-9_]+)\}/i"; // macro delimiter "{" and "}" 
  $replacementFunction    = "parseText";  //Method callbacks are performed this way 
  $template               = file_get_contents($templateFile);      
  $parsedTemplate         = preg_replace_callback($searchPattern, $replacementFunction, $fileData); 
  
  
  $parsedTemplate = "";	
	
  return $parsedTemplate;	
}

$output = your_method_to_get_the_full_template_contents();
$loop_with_tags = your_method_to_find_the_loop_tags_and_content($output, 'users');
$loop_inside_tags = your_method_to_get_the_loop_contents($loop_with_tags);

$loop_output = '';
foreach($users as $user) {
    $loop_output .= str_replace(array_keys($user), array_values($user), $loop_inside_tags);
}

$output = str_replace($loop_with_tags, $loop_output, $output);*/

?>