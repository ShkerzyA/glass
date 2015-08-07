<?php
/* @var $this WorkplaceController */
/* @var $data Workplace */
if(Yii::app()->user->checkAccess('moderator'))
	echo CHtml::submitButton('Изменить выделенные',array('style'=>'width: 200px; float: left;'));
?>