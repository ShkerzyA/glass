<?php
/* @var $this TasksStatusController */
/* @var $model TasksStatus */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tasks-status-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'label'); ?>

		<?php echo $form->textField($model,'label',array('size'=>60,'maxlength'=>100)); ?>

		<?php echo $form->error($model,'label'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'css_class'); ?>

		<?php echo $form->textField($model,'css_class',array('size'=>60,'maxlength'=>100)); ?>

		<?php echo $form->error($model,'css_class'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'css_status'); ?>

		<?php echo $form->textField($model,'css_status',array('size'=>60,'maxlength'=>100)); ?>

		<?php echo $form->error($model,'css_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sort'); ?>

		<?php echo $form->textField($model,'sort'); ?>

		<?php echo $form->error($model,'sort'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->