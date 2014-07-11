<?php
/* @var $this MessagesController */
/* @var $model Messages */
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
		<?php echo $form->label($model,'ttext'); ?>
		<?php echo $form->textArea($model,'ttext',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'timestamp'); ?>
		<?php echo $form->textField($model,'timestamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'type'); ?>
		<?php echo $form->textField($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'creator'); ?>
		<?php echo $form->textField($model,'creator'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'users'); ?>
		<?php echo $form->textField($model,'users'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'groups'); ?>
		<?php echo $form->textField($model,'groups'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'departments'); ?>
		<?php echo $form->textField($model,'departments'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Искать'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->