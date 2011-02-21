<?php if(!isset($this)) die("You can't run these files"); ?>
<!-------------- Next Example ---------------->

<div class="info">
<h2>Basic Replace</h2>
<i>Simple replace of two variables that have been defined</i>
<pre><?php $this->printValue("title"); ?>: <?php $this->printValue("subtitle"); ?></pre>
<pre>{title}: {subtitle}</pre>
</div>

<!-------------- Next Example ---------------->

<div class="info">
<h2>If/Else with Value</h2>
<i>Using a predefined value with an if/else statement</i>
<pre>
Value: <?php $this->printValue("true"); ?> 
Tested: 
<?php if($this->data->true) { ?>
	True
<?php } else { ?>
	Not True
<?php } ?>
</pre>

<pre>
Value: {true}<br />
{if:true}
	True
{else}
	Not True
{end}
</pre>
</div>

<!-------------- Next Example ---------------->

<div class="info">
<h2>If/Else with Boolean</h2>
<i>Using a boolen calculation in the HTML for evaluation</i>
<pre>
Tested: 
<?php if(100>0) { ?>
	True
<?php } else { ?>
	False
<?php } ?>
</pre>

<pre>
Tested: 
{if:100>0}
	True
{else}
	False
{end}
</pre>
</div>

<!-------------- Next Example ---------------->

<div class="info">
<h2>Switch</h2>
<i>Switch upon a predefined variable, comparing with provided strings</i>
<pre>
Value: <?php $this->printValue("name"); ?> 
Tested:
<?php switch($this->data->name) { default:  ?>
<?php break; case "dave": ?> Was dave
<?php break; case "john": ?> Was john
<?php break; case "steve": ?> Was steve
<?php } ?>
</pre>

<pre>
Value: {name}
Tested:
{switch:name}
	{case:"dave"} Was dave
	{case:"john"} Was john
	{case:"steve"} Was steve
{endswitch}
</pre>
</div>

<!-------------- Next Example ---------------->

<div class="info">
<h2>ForEach</h2>
<i>Loop over a predefined array, outputting each value</i>
<pre>
Value: <?php $this->printValue("people"); ?> 
Tested:<?php foreach($this->data->people as $this->data->value) {  ?> 
	<?php $this->printValue("value"); ?>
<?php } ?> 
</pre>

<pre>
Value: {people}
Tested:
{foreach:people,value} 
	{value}
{end} 
</pre>
</div>

<!-------------- Next Example ---------------->

<div class="info">
<h2>ForEachKey</h2>
<i>Loop over a predefined array, outputting each value and key</i>
<pre>
Value: <?php $this->printValue("people"); ?> 
Tested:<?php foreach($this->data->people as $this->data->i=>$this->data->value) {  ?> 
	<?php $this->printValue("i"); ?> <?php $this->printValue("value"); ?>
<?php } ?>
</pre>

<pre>
{foreach:people,i,value} 
	{i} {value}
{end}
</pre>
</div>

<!-------------- Next Example ---------------->

<div class="info">
<h2>Ignore</h2>
<i>Tell the Parser to ignore the variables in the line</i>
<pre>
{ignored}
</pre>

<pre>
{!}{ignored}
</pre>
</div>

<!-------------- Next Example ---------------->

<div class="info">
<h2>Arrays</h2>
<i>Access a predefined array via index</i>
<pre>
<?php echo $this->data->people[0]; ?>
</pre>

<pre>
{people[0]}
</pre>
</div>

<!-------------- Next Example ---------------->

<div class="info">
<h2>Objects</h2>
<i>Access an predefined objects function</i>
<pre>
<?php echo $this->data->person->fullName(); ?>
</pre>

<pre>
{person.fullName()}
</pre>
</div>