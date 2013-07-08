<?php
/* @var $this WorkplaceController */
/* @var $model Workplace */
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
		<?php echo $form->label($model,'id_cabinet'); ?>
		<?php echo $form->textField($model,'id_cabinet'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_personnel'); ?>
		<?php echo $form->textField($model,'id_personnel'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'wname'); ?>
		<?php echo $form->textField($model,'wname',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Искать'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->