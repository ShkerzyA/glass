<?php
/* @var $this EventsoperController */
/* @var $model Eventsoper */
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
		<?php echo $form->label($model,'id_room'); ?>
		<?php echo $form->textField($model,'id_room'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date'); ?>
		<?php echo $form->textField($model,'date'); ?>
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
		<?php echo $form->label($model,'fio_pac'); ?>
		<?php echo $form->textField($model,'fio_pac',array('size'=>60,'maxlength'=>250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'creator'); ?>
		<?php echo $form->textField($model,'creator'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'operator'); ?>
		<?php echo $form->textField($model,'operator'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_gosp'); ?>
		<?php echo $form->textField($model,'date_gosp'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'brigade'); ?>
		<?php echo $form->textField($model,'brigade'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'anesthesiologist'); ?>
		<?php echo $form->textField($model,'anesthesiologist'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'operation'); ?>
		<?php echo $form->textField($model,'operation'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'type_operation'); ?>
		<?php echo $form->textField($model,'type_operation'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Искать'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->