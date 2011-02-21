<?php if(!isset($this)) die("You can't run these files"); ?><!DOCTYPE html>
<html>
<head>
<title><?php $this->printValue("website"); ?>: <?php $this->printValue("title"); ?></title>
<style>
/* Ugly as hell css to try and keep the examples easy to read */
/* Sorry if it breaks everything <3 */
body {
	background-color: #FFFFF0;
	color: #444;  
}
h1 {
	text-align:center;
	font-family: Tahoma, Geneva, sans-serif;
	text-shadow: 2px 2px 3px rgba(50,50,50,0.5);
	transform: rotate(1deg);
	-webkit-transform: rotate(1deg);
	filter: dropshadow(color=rgba(50,50,50,0.5), offx=2, offy=2);
}
h2 {
	margin: 0px;
	font-family: Tahoma, Geneva, sans-serif;
}
pre {
	margin: 5px 10px;
	background-color: #F4F4F4;
	border: 1px solid #CCC;	
}
div {
	margin: 10px auto;
	width: 500px;
}
.info {
	background-color: #eceff6;  
    border: 1px solid #d4dae8;  
    padding: 10px;  
	box-shadow: 5px 5px 10px rgba(50,50,50,0.5);
	-moz-box-shadow: 5px 5px 10px rgba(50,50,50,0.5);
	-webkit-box-shadow: 5px 5px 10px rgba(50,50,50,0.5);
	-moz-border-radius: 5px;
	border-radius: 5px;
}
i {
	margin-left: 5px;	
}
a {
	padding: 8px;
	width: 153px;
	display: inline-block;
	text-align:center;
	background-color: #d8dfea;
	color: #333333;
	font-weight: bold;
	margin-right: 4px;
	text-decoration: none;
	box-shadow: 5px 5px 10px rgba(50,50,50,0.5);
	-moz-box-shadow: 5px 5px 10px rgba(50,50,50,0.5);
	-webkit-box-shadow: 5px 5px 10px rgba(50,50,50,0.5);
	-moz-border-radius: 5px;
	border-radius: 5px;	
	height: auto;
}
a:hover {
	background-color: #3b5998;
	color: #ffffff;
	cursor: hand;
}
.menu {
	margin: 15px auto; 
	width: 520px;
	text-align:center;
}
</style>
</head>

<body>
<h1><?php $this->printValue("title"); ?>: <?php $this->printValue("subtitle"); ?></h1>

<?php echo $this->output("demoPegParseExamples.html"); ?>

</body>
</html>
