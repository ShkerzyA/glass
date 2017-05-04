<?php
/* @var $this ActOfTransferController */
/* @var $model ActOfTransfer */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'act-of-transfer-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'timestamp'); ?>

		<?php echo $form->textField($model,'timestamp'); ?>

		<?php echo $form->error($model,'timestamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>

		<?php echo $form->textField($model,'status'); ?>

		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'transferring'); ?>

		<?php echo $form->textField($model,'transferring'); ?>

		<?php echo $form->error($model,'transferring'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'receiving'); ?>

		<?php echo $form->textField($model,'receiving'); ?>

		<?php echo $form->error($model,'receiving'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'receiving_var'); ?>

		<?php echo $form->textField($model,'receiving_var',array('size'=>60,'maxlength'=>100)); ?>

		<?php echo $form->error($model,'receiving_var'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'creator'); ?>

		<?php echo $form->textField($model,'creator'); ?>

		<?php echo $form->error($model,'creator'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->