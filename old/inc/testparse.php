<?php
//Parse Tester

error_reporting(E_ALL);
include('parse2.0.php');

$PAGE['name'] = 'Peg';
$PAGE['title'] = 'Template';
$PAGE['subtitle'] = 'Testing the Parser';

$t = new pegt();
$t->config("rootDir", $_SERVER['DOCUMENT_ROOT']."/Bernie/inc/");
$t->config("templateDir", "templates/");
$t->config("compileDir", "tmp/");
$t->config("warning", true);

$t->assign($PAGE);

//If/else
$t->assign('true', true);
$t->assign('false', true);

echo $t->output("test.html");

?>