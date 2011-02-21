<?php if(!isset($this)) die("You can't run these files"); ?><!DOCTYPE html>
<html>
<head>
<title><?php $this->printValue("name"); ?>: <?php $this->printValue("title"); ?></title>
</head>

<body>
<h1><?php $this->printValue("title"); ?>: <?php $this->printValue("subtitle"); ?></h1>
<?php $this->printValue("content"); ?>
<br /><br />
<a href="javascript:history.go(-1)">Go Back</a><br />
<?php $this->printValue("footer"); ?>
</body>
</html>
