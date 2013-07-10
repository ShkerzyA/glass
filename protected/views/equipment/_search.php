<?php
/* @var $this EquipmentController */
/* @var $model Equipment */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_workplace'); ?>
		<?php echo $form->textField($model,'id_workplace'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'serial'); ?>
		<?php echo $form->textField($model,'serial',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ename'); ?>
		<?php echo $form->textField($model,'ename',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Искать'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->