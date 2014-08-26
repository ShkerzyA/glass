<?php
/* @var $this PostsGroupsController */
/* @var $model PostsGroups */
/* @var $form CActiveForm */
?>

<div class="back">
<div class="back_in_black"></div>
<div class="window_awesom">
<div id="back" class='close_this'></div>

<input type=text class="search_oper" id='<?php echo $field ?>' value='<?php echo $name; ?>' name="post_name" placeholder="Поиск операции" autofocus>
<br>
<?php 

	if(!empty($modelN)){
		if(!empty($model))
		foreach ($model as $v){
			echo "<div id='$v->id' text='".$v->name."' class='replace_personnel' f=".$field." field=".$modelN."[".$field."]>".$v->name."</div>";	
		}	
	}else{
		if(!empty($model))
		foreach ($model as $v){
			echo "<div id='$v->id' text='".$v->name."' class='join_personnel' f=".$field." field=".$field.">".$v->name."</div>";	
		}	
	}
	
?>

</div></div><!-- form -->