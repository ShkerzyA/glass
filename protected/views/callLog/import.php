<?php
/* @var $this CallLogController */

$this->breadcrumbs=array(
	'Call Log',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<form enctype="multipart/form-data" method="post">
   <p><input type="file" name="f">
   <input type="submit" value="Обработать"></p>
</form> 

<?php 
	$i=1;
	foreach ($file as $v) {
		//echo $i.' | '.implode('^',$v[0])."\n<br>";
		print_r($v);
		$i++;
	}
?>
