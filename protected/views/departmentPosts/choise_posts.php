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
		if(!empty($v->personnelPostsHistories[0])){
			echo "<div id='$v->id' text='".$v->personnelPostsHistories[0]->idPersonnel->surname."  ".$v->personnelPostsHistories[0]->idPersonnel->name."' class='join_post'>".$v->personnelPostsHistories[0]->idPersonnel->surname."  ".$v->personnelPostsHistories[0]->idPersonnel->name."</div>";	
		}
		
	}
?>

</div></div><!-- form -->