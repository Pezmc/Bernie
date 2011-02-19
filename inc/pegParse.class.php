<?php

/*/ 
 * Peg Template Parsing Helper
 *
 * Works by reading template files with a predefined syntax, creating PHP files from them and then running that PHP.
 * In the long run aims to cache these files etc...
 *
 * Usage: See README or index.php
 *
 * Version: 1.1b
 *
 * Changelog:
 *   1.1b - Caching of the HTML
 *   1.0b - Various bug fixes
 *   0.9b - Added info boxes for errors, basic if/else parsing, use printvalue instead of echo to display contents
 * 	 Pre 0.9 Trimmed
 *
 * Ideas:
 *   - Improve if/else to support things like variable > variable
 *   - Add option to strip PHP from HTML first
 *   - Allow use of functions in the page
 *
 * Devs: Pez Cuckow
/*/

class pegParse {
	private $root; // Where to start looking
	private $tmp; // Where to store compiled temp files
	private $templates; //Where are the template files stored?
	private $warning; //Are we outputting warnings	
	private $version = '1.1b'; //Current version
	private $stripPHP; //Do we want php removed?
	private $cachePHP; //Cache the PHP?
	private $cacheHTML; //Cache the HTML?
	
	private $data; // a stdClass object to hold the data passed to the template
	private $servedBy; //What was most recently served

	/* 
	 * Sets all the defaults 
	 */
	function __construct() {
		$this->data = new stdClass;
		
		$this->root = $this->appendSeparator($_SERVER['DOCUMENT_ROOT']);
		$this->tmp = '/tmp/' . $_SERVER['HTTP_HOST'] . '/';
		$this->data = new stdClass;
		$this->templates = $this->root.'templates/';
		
		$this->warning = false;
		$this->stripPHP = false;
		$this->cachePHP = true;
		$this->cacheHTML = true;
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
			. "\n\t".'<div style="background-color:#'.($error ? 'ffebe8' : 'fff9d7').';display:inline-block;margin:1px;'
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
			case "stripPHP": $this->stripPHP = (boolean) $value; break;
			case "cachePHP": $this->cachePHP = (boolean) $value; break;
			case "cacheHTML": $this->cacheHTML = (boolean) $value; break;
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
		
		foreach($template as $t) { //For every template given
			$path = $this->appendSeparator($this->templates); //The tmp dir
			
			if(file_exists($path . $t)) { //Does the template exist?
				$this->setServedBy();
				$output .= $this->cachedOutput($path, $t).$this->getServedBy();
			} else {
				$this->doError('Template (' . $t . ') not found in ' . $path);
			}
		}	
			
		return $output;
	}
	
	/*
	 * Returns cached HTML or bufferedOutput
	 */
	function cachedOutput($path, $template) {
		$dataHash = hash('salsa10', $template.serialize($this));
		$cachedHTML = $this->tmp . $dataHash.'.html';
		if(file_exists($cachedHTML)&&filemtime($cachedHTML) >= filemtime($path.$template)) { //Is the HTML cached?
			$this->setServedBy('Cached HTML');
			return file_get_contents($cachedHTML); //Load from the HTML cache
		} else {
			return $this->bufferedOutput($path, $template);
		}
	}

	/*
	 * Returns the template given, after it has been located
	 *
	 * Passes the file to the compile method to be created if it doesn't exists
	 */
	private function bufferedOutput($path, $template) {
		//Get hash before compile changes things
		if($this->cacheHTML) {
			$dataHash = hash('salsa10', $template.serialize($this));
			$compiledHTML = $this->tmp . $dataHash.'.html';
		}
		
		//Are we caching php?
		if($this->cachePHP) { 
			$this->compile($path, $template); //Compile the page PHP if needed
	
			ob_start(); //Buffer everything
			$cachedPHP = $this->tmp . md5($path.$template) . '.php';
			if(file_exists($cachedPHP)) {
				include($cachedPHP); //Show the page
			} else {
				$this->doError('The PHP cache file '.$cachedPHP.' coudln\'t be found, try reloading or check permissions');
			}
			$output = ob_get_clean(); //Clear the buffer
		} else {
			$output = eval('?>'.$this->compile($path, $template).'<?php ');
		}
		
		//Cache the output as HTML
		if($this->cacheHTML) {
			if(!is_writable($this->tmp)) {
				$this->doError('I don\'t have permission to create '.$compiledHTML.', please chmod the dir to 777');
			} else {
				$f = fopen($compiledHTML, 'w');
				fwrite($f, $output);
				fclose($f);
			}
		}
		
		return $output;
	}

	/*
	 * Compiles the template to PHP code and saves to file ... but only if the template has been updated since the last caching
	 * Uses Regular Expressions to identify template syntax
	 * Passes each match on to the callback for conversion to PHP
	 */
	private function compile($path, $template) {
		if(!file_exists($this->tmp)) { //No tmp dir?!?
			if(!mkdir($this->tmp, 0777, true)) {
				$this->doError('I don\'t have permission to create '.$this->tmp.', please create manually or correct permissions');
			}
		}

		$templateFile = $path . $template;
		if($this->cachePHP) {
			$compiledFile = $this->tmp . md5($templateFile) . '.php';
			if(!is_writable($this->tmp)) {
				$this->doError('I don\'t have permission to create '.$compiledFile.', please chmod the dir to 777');
			}
		}

		//Does the file already exist and is it the same?
		if($this->cachePHP&&file_exists($compiledFile) && filemtime($compiledFile) >= filemtime($templateFile)) {
			$this->setServedBy('Cached PHP');
			return;
		} else {
			$this->setServedBy('Fresh PHP');
		}

		$lines = file($templateFile);
		if($this->stripPHP) $lines = preg_replace('/<\?[^?>]*(.*?)\?>/', '', $lines);
		$newLines = array();
		$newLines[] = '<?php if(!isset($this)) die("You can\'t run these files"); ?>'; //Stop access of the PHP files
		$matches = null;
		foreach($lines as $line)  {
			$num = preg_match_all('/\{([^{}]+)\}/', $line, &$matches);
			if($num > 0) {
				if(strpos($line,'{!}') === false) {
					for($i = 0; $i < $num; $i++) {
						$match = $matches[0][$i];
						$new = $this->transformSyntax($matches[1][$i]);
						$line = str_replace($match, $new, $line);
					}
				} else {
					$line = preg_replace('/{!}/', '', $line, 1);	
				}
			}
			$newLines[] = $line;
		}
		if($this->cachePHP) {
			$f = fopen($compiledFile, 'w');
			fwrite($f, implode('',$newLines));
			fclose($f);
		} else {
			return implode('',$newLines);
		}
	}

	/*
	 * Convert the template into PHP to be run
	 */
	private function transformSyntax($input) {
		/* Searches for nested variables */
		$from = array(
			'/(^|\[|,|\(|\+| )([a-zA-Z_][a-zA-Z0-9_]*)($|\.|\)|\[|\]|\+)/',
			'/(^|\[|,|\(|\+| )([a-zA-Z_][a-zA-Z0-9_]*)($|\.|\)|\[|\]|\+)/', // again to catch those bypassed by overlapping start/end characters 
			'/(^")([a-zA-Z_][a-zA-Z0-9_]*)(^")/',
			'/\./',
		);
		$to = array(
			'$1$this->data->$2$3',
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
				if(preg_match('/\[.*\]|\./', $parts[0])) //if it's array or object
					$string .= 'echo '.preg_replace($from, $to, $parts[0]).';';
				else
					$string .= '$this->printValue("' . $parts[0] . '");';
				break;
		}
		$string .= ' ?>';
		return $string;
	}
	
	/*
	 * Generate the servedBy message
	 */
	private function setServedBy($type = null) {
		if(!empty($type))
			$this->servedBy = $type;
		else
			$this->servedBy = null;
	}
	
	/*
	 * Generate the servedBy message
	 */
	private function getServedBy() {
		if(!empty($this->servedBy))
			return '<!-- Served by pegParse '.$this->version.' from '.$this->servedBy.' -->';
		else
			return '';
	}	
	
}

?>