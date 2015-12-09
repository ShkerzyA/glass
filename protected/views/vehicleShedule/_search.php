<?php
/* @var $this VehicleSheduleController */
/* @var $model VehicleShedule */
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
		<?php echo $form->label($model,'date_begin'); ?>
		<?php echo $form->textField($model,'date_begin'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_end'); ?>
		<?php echo $form->textField($model,'date_end'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'timestamp'); ?>
		<?php echo $form->textField($model,'timestamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'timestamp_end'); ?>
		<?php echo $form->textField($model,'timestamp_end'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'creator'); ?>
		<?php echo $form->textField($model,'creator'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'week'); ?>
		<?php echo $form->textField($model,'week'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'weekdays'); ?>
		<?php echo $form->textField($model,'weekdays'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'holydays'); ?>
		<?php echo $form->textField($model,'holydays'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Искать'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->