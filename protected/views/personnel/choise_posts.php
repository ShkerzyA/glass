<?php
/* @var $this PostsGroupsController */
/* @var $model PostsGroups */
/* @var $form CActiveForm */
?>

<div class="back">
<div class="back_in_black"></div>
<div class="window_awesom">
<div id="back" class='close_this'></div>
<br>
<?php 
	foreach ($model as $v){
		if(!empty($v)){
			echo "<div id='$v->id' text='".$v->surname."  ".$v->name."' class='join_post'>".$v->surname."  ".$v->name."</div>";	
		}
		
	}
?>

</div></div><!-- form -->