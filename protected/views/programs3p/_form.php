<?php
/* @var $this Programs3pController */
/* @var $model Programs3p */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'programs3p-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>

		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>

		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_date'); ?>

		<?php echo $form->textField($model,'create_date'); ?>

		<?php echo $form->error($model,'create_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'close_date'); ?>

		<?php echo $form->textField($model,'close_date'); ?>

		<?php echo $form->error($model,'close_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->