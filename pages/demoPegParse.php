<?php

/*/
 * pages/demoPegParse.php
 *
 * A demo of how pegParse could be used, ours is much less complex in general
 *
 * Devs: Pez
 *
/*/

$t = new pegParse();
$t->config("rootDir", $_SERVER['DOCUMENT_ROOT']."/Bernie/");
$t->config("templateDir", "templates/");
$t->config("compileDir", "tmp/");

$page = "examples";

$PAGE['website'] = 'PegParse';
$PAGE['title'] = 'PegParse';
$PAGE['subtitle'] = 'Examples of Parsing';

//Page Info
$t->assign($PAGE);

//Current page
$t->assign('page', $page);

if ($page=="examples") {  //Extra stuff for the examples page
	//If/else
	$t->assign('true', true);
	$t->assign('false', false);

	//Switch
	$t->assign('name', 'steve');

	//ForEach
	$t->assign('people', array('Pez', 'John', 'George'));

	//Object
	class person {
		public $name;
		function __construct() {
			$this->name = array(
				'first' => 'James',
				'last' => 'Dean'
			);
		}


		public function fullName() {
			return implode(' ', $this->name);
		}


	}


	$t->assign('person', new person());
}

//Echo the output
die($t->output("demoPegParse.html"));

?>