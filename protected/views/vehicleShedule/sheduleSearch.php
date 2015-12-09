<?php
/* @var $this PostsGroupsController */
/* @var $model PostsGroups */
/* @var $form CActiveForm */
?>

<div class="back">
<div class="back_in_black"></div>
<div class="window_awesom">
<div id="back" class='close_this'></div>

<div class='body_res'>
<?php 
	
	if(!empty($model)){
		switch ($action) {
			case 'join':
					foreach ($model as $v){
						echo "<div id='$v->id' text='".$v->name()."' class='join_personnel' f=".$field." field=".$modelN."[".$field."][$v->id]>".$v->name()."</div>";	
					}	
				break;

			case 'replace':
					foreach ($model as $v){
						echo "<div id='$v->id' text='".$v->name()."' class='replace_personnel' f=".$field." field=".$modelN."[".$field."]>".$v->name()."</div>";	
					}	
				break;
			
			default:
				# code...
				break;
		}
	}
	
?>
</div>

</div></div><!-- form -->