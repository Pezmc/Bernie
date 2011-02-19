<?php

/*/ 
 * Peg Template Parsing Helper
 *
 * Works by reading template files with a predefined syntax, creating PHP files from them and then running that PHP.
 * In the long run aims to cache these files etc...
 *
 * Construction guided from vemplator (Copyright (C) 2005-2008  Alan Szlosek), however written from scratch.
 *
 * Usage: See README
 *
 * Devs: Pez
/*/

class pegt {
	private $root; // Where to start looking
	private $tmp; // Where to store compiled temp files
	private $data; // a stdClass object to hold the data passed to the template
	private $templates; //Where are the template files stored?
	private $warning; //Are we outputting warnings

	/* 
	 * Sets all the defaults 
	 */
	function __construct() {
		$this->root = $this->appendSeparator($_SERVER['DOCUMENT_ROOT']);
		$this->tmp = '/tmp/' . $_SERVER['HTTP_HOST'] . '/';
		$this->data = new stdClass;
		$this->templates = $this->root.'templates/';
		$this->warning = false;
		
		//$this->doCache = false;
		//$this->doStripCode = true;
	}
	
	/*
	 * Output an error so it looks nice and die
	 */
	private function doError($error) {
		die($this->infoBox(true, $error));	
	}
	
	/*
	 * Output a warning but keep the page going
	 */
	private function doWarning($warning) {
		print($this->infoBox(false, $warning));		
	}
	
	/*
	 * Returns a pretty information box either red or yellow
	 */
	private function infoBox($error = true, $message) {
		return "\n".'<div style="display:block">'
			. "\n\t".'<div style="background-color:#'.($error ? 'ffebe8' : 'fff9d7').';display:inline-block;'
			. "\n\t\t\t".'border:1px solid #'.($error ? 'dd3c10' : 'e2c822').';color:#333333;padding:10px;font-size:14px;font-weight:normal;">'
			. "\n\t\t".'<b>Peg Template '.($error ? 'Error' : 'Warning').'</b><br />'
			. "\n\t\t".$message
			. "\n\t".'</div>'
			. "\n".'</div>'."\n";
	}
	
	/**
	 * Change the system defaults
	 * 
	 * Checks are made on values provided
	 */
	public function config($key, $value) {
		switch ($key) {
			case "rootDir": $this->root = $this->setPath($value); break;
			case "templateDir": $this->templates = $this->setPath($value); break;
			case "compileDir": $this->tmp = $this->setPath($value); break;
			case "warning": $this->warning = (boolean) $value; break;
			default: $this->doError('Unknown config value '.$key.' set');	
		}
	}
	
	/*
	 * Does the specified path exist?
	 *
	 * Adds / at end and beginning if needed
	 */
	private function setPath($path) {
		$path = $this->appendSeparator($path);
		$path = $this->prependRoot($path);
		if(file_exists($path)) {
			return $path;
		} else {
			$this->doError('Tried to change path to unexistant dir: '.$path);	
		}
	}
	
	/*
	 * Makes sure folders have a trailing slash
	 */
	private function appendSeparator($path) {
		$path = trim($path);
		if(substr($path, strlen($path)-1, 1) != DIRECTORY_SEPARATOR)
			$path .= DIRECTORY_SEPARATOR;
		return $path;
	}	
	
	/*
	 * Is a forward slash needed? 
	 */
	private function prependRoot($dir) {
		$dir = $this->appendSeparator($dir);
		if($dir{0} != '/') {
			return $this->root . $dir;
		} else {
			return $dir;
		}
	}

	/**
	 * Set a variable(s) to be replaced
	 * Can be a key and value or array of key => values
	 */
	public function assign($key, $value = '') {
		if(is_array($key)) { //Create lots of new keys
			foreach($key as $name=>$value) {
				$this->data->$name = $value;
			}
		} elseif(is_object($key)) { //Convert objets to array
			foreach(get_object_vars($key) as $name=>$value) {
				$this->data->$name = $value;
			}
		} else {
			$this->data->$key = $value;
		}
	}

	/**
	 * Takes a key, value pair and adds the data
	 *
	 * If key doesn't exist creates it
	 */
	public function append($key, $value = '') {
		if(!property_exists($this->data, $key)) {
			$this->data->$key = '';
		}
		$this->data->$key .= $value;
	}

	/*
	 * Stack onto an existing array
	 *
	 * If key doesn't exist creates new array
	 */
	public function push($key, $value = null) {
		if(!property_exists($this->data, $key)) {
			$this->data->$key = array();
		}
		$data = $this->data->$key; //Get current array
		$data[] = $value; //Add value to array
		$this->data->$key = $data; //Replace old key
	}

	/**
	 * Clears all given values so far
	 */
	public function clear() {
		$this->data = new stdClass;
	}
	
	/**
	 * Print the value asked for, or error
	 */
	public function printValue($key) {
		if(isset($this->data->$key)) {
			echo $this->data->$key;
		} elseif ($this->warning) {
			$this->doWarning($key.' doesn\'t exist, but is being requested?');	
		}
	}
	
	/*
	 * Return the name of a var
	 */
	private function varName (&$iVar, &$aDefinedVars) {
		foreach ($aDefinedVars as $k=>$v)
			$aDefinedVars_0[$k] = $v;
	 
		$iVarSave = $iVar;
		$iVar     =!$iVar;
	 
		$aDiffKeys = array_keys (array_diff_assoc ($aDefinedVars_0, $aDefinedVars));
		$iVar      = $iVarSave;
	 
		return $aDiffKeys[0];
    }

	/**
	 * Grabs a template and returns the output
	 *
	 * Checks if the file exists and then works the magic
	 */
	public function output($template) {
		if(!is_array($template))
			$template = explode('|',$template); //More than one requested?
			
		$output = '';
		$foundTemplate = false;
		foreach($template as $t) { //For every template given
			$path = $this->appendSeparator($this->templates); //The template dir
			if(file_exists($path . $t)) {
				$output .= $this->bufferedOutput($path, $t);
				$foundTemplate = true;
			} else {
				$this->doError('Template (' . $t . ') not found in ' . $path);
			}
		}	
			
		return $output;
	}

	/*
	 * Returns the template given, after it has been located
	 *
	 * Passes the file to the compile method to be created if it doesn't exists
	 */
	private function bufferedOutput($path, $template) {
		$this->compile($path, $template);

		ob_start(); //Buffer everything
		include($this->tmp . $template . '.php'); //Show the page
		$output = ob_get_clean(); //Clear the buffer
		return $output;
	}

	/*
	 * Compiles the template to PHP code and saves to file ... but only if the template has been updated since the last caching
	 * Uses Regular Expressions to identify template syntax
	 * Passes each match on to the callback for conversion to PHP
	 */
	private function compile($path, $template) {
		if(!file_exists($this->tmp)) { //No tmp dir?!?
			if(!mkdir($this->tmp)) {
				$this->doError('I don\'t have permission to create '.$this->tmp.', please create manually or correct permissions');
			}
		}

		$templateFile = $path . $template;
		$compiledFile = $this->tmp . $template . '.php';
		
		if(!is_writable($this->tmp)) {
			$this->doError('I don\'t have permission to create '.$compiledFile.', please chmod the dir to 777');
		}

		//Does the file already exist and is it the same?
		if(file_exists($compiledFile) && filemtime($compiledFile) >= filemtime($templateFile))
			return;

		$lines = file($templateFile);
		$newLines = array();
		$matches = null;
		foreach($lines as $line)  {
			$num = preg_match_all('/\{([^{}]+)\}/', $line, &$matches);
			if($num > 0) {
				for($i = 0; $i < $num; $i++) {
					$match = $matches[0][$i];
					$new = $this->transformSyntax($matches[1][$i]);
					$line = str_replace($match, $new, $line);
				}
			}
			$newLines[] = $line;
		}
		$f = fopen($compiledFile, 'w');
		fwrite($f, implode('',$newLines));
		fclose($f);
	}
	

	/*
	 * Convert the template into PHP to be run
	 */
	private function transformSyntax($input) {
		/* Searches for nested variables */
		$from = array(
			'/(^|\[|,|\(|\+| )([a-zA-Z_][a-zA-Z0-9_]*)($|\.|\)|\[|\]|\+)/',
			'/(^|\[|,|\(|\+| )([a-zA-Z_][a-zA-Z0-9_]*)($|\.|\)|\[|\]|\+)/', // again to catch those bypassed by overlapping start/end characters 
			'/\./',
		);
		$to = array(
			'$1$this->data->$2$3',
			'$1$this->data->$2$3',
			'->'
		);
		
		$parts = explode(':', $input);
		
		
		/* Create a php string from given info */
		$string = '<?php ';
		switch($parts[0]) { // check for a template statement
			case 'if':
				//$string .= 'if(eval("return ('.preg_replace($from, $to, $parts[1]).');")) {';
				$string .= 'if('.preg_replace($from, $to, $parts[1]).') {';
				break;
			case 'switch':
				$string .= $parts[0] . '(' . preg_replace($from, $to, $parts[1]) . ') { ' . ($parts[0] == 'switch' ? 'default: ' : '');
				break;
			case 'foreach':
				$pieces = explode(',', $parts[1]);
				$string .= 'foreach(' . preg_replace($from, $to, $pieces[0]) . ' as ';
				$string .= preg_replace($from, $to, $pieces[1]);
				if(sizeof($pieces) == 3) // prepares the $value portion of foreach($var as $key=>$value)
					$string .= '=>' . preg_replace($from, $to, $pieces[2]);
				$string .= ') { ';
				break;
			case 'end':
				$string .= '}';
				break;
			case 'endswitch':
				$string .= '}';
				break;
			case 'else':
				$string .= '} else {';
				break;
			case 'case':
				$string .= 'break; case ' . preg_replace($from, $to, $parts[1]) . ':';
				break;
			case 'include':
				$string .= 'echo $this->output("' . $parts[1] . '");';
				break;
			default:
				$string .= '$this->printValue("' . $parts[0] . '");';
				break;
		}
		$string .= ' ?>';
		return $string;
	}
}

?>