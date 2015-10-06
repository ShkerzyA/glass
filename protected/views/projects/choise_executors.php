<?php
/* @var $this PostsGroupsController */
/* @var $model PostsGroups */
/* @var $form CActiveForm */
?>

<div class="back">
<div class="window_awesom">
<div id="back" class='close_this'></div>
<br>
<div>
<?php 
	foreach ($model as $k=>$v){
		echo "<div id='$k' field=".$mn."[executors][$k] text='$v' f='executors' class='join_personnel'>$v</div>";
	}
?>
</div>
</div></div><!-- form -->