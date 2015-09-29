<?php
/* @var $this ProjectsController */
/* @var $model Projects */
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
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
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
		<?php echo $form->label($model,'id_department'); ?>
		<?php echo $form->textField($model,'id_department'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'executors'); ?>
		<?php echo $form->textField($model,'executors'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'group'); ?>
		<?php echo $form->textField($model,'group'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Искать'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->