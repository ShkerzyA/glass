<?php

Yii::app()->clientScript->registerScript('msupd', "
var mchck=false;
$('.check_mass_checkbox').click(function(){
	if(mchck){
		mchck=false;
		$('.mass_checkbox').prop('checked','');	
	}else{
		mchck=true;
		$('.mass_checkbox').prop('checked','checked');	
	}
	
	return false;
});
");
/* @var $this WorkplaceController */
/* @var $data Workplace */
echo'<div class="clear"></div>';
if(Yii::app()->user->checkAccess('moderator'))
	echo CHtml::Button('Выделить все',array('class'=>'check_mass_checkbox','style'=>'width: 200px; float: left;'));
	echo CHtml::submitButton('Изменить выделенные',array('style'=>'width: 200px; float: left;'));
?>