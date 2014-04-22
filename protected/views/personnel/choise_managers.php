<?php
/* @var $this PostsGroupsController */
/* @var $model PostsGroups */
/* @var $form CActiveForm */
?>

<div class="back">
<div class="back_in_black"></div>
<div class="window_awesom">
<div id="back" class='close_this'></div>

<input type=text id="search_surname" name="post_name" placeholder="Поиск по Фамилии">
<br>
<?php 
	foreach ($model as $v){
			echo "<div id='$v->id' text='".$v->surname."  ".$v->name."' class='join_managers'>".$v->surname."  ".$v->name."/".$v->id."</div>";	
		
	}
?>

</div></div><!-- form -->