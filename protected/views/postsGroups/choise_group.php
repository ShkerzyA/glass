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
	foreach ($model as $v){
		echo "<div id='$v->group_key' f='$field' field=".$mn."[$field][$v->group_key] text='$v->group_name' class='join_group'>$v->group_name</div>";
	}
?>
</div>
</div></div><!-- form -->