<?php
/* @var $this WorkplaceController */
/* @var $data Workplace */
echo'<div class="clear"></div>';
if(Yii::app()->user->checkAccess('moderator'))
	echo CHtml::Button('Выделить все',array('class'=>'check_mass_checkbox','style'=>'width: 200px; float: left;'));
	echo CHtml::submitButton('Изменить выделенные',array('style'=>'width: 200px; float: left;'));
?>