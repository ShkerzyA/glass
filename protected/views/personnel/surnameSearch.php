<?php
/* @var $this PostsGroupsController */
/* @var $model PostsGroups */
/* @var $form CActiveForm */
?>

<div class="back">
<div class="back_in_black"></div>
<div class="window_awesom">
<div id="back" class='close_this'></div>

<input type=text class="search_surname" id='<?php echo $field ?>' name="post_name" placeholder="Поиск по Фамилии">
<br>
<?php 

	if(!empty($modelN)){
		foreach ($model as $v){
			echo "<div id='$v->id' text='".$v->surname." ".$v->name." ".$v->patr."' class='replace_personnel' f=".$field." field=".$modelN."[".$field."]>".$v->surname." ".$v->name." ".$v->patr."</div>";	
		}	
	}else{
		foreach ($model as $v){
			echo "<div id='$v->id' text='".$v->surname." ".$v->name." ".$v->patr."' class='join_personnel' f=".$field." field=".$field.">".$v->surname." ".$v->name." ".$v->patr."</div>";	
		}	
	}
	
?>

</div></div><!-- form -->