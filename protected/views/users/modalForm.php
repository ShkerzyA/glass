<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	'id'=>'users-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>

		<?php echo $form->textField($model,'username',array('size'=>50,'maxlength'=>50)); ?>

		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>

		<?php echo $form->passwordField($model,'password',array('size'=>50,'maxlength'=>50)); ?>

		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model->personnels,'photo'); ?>

		<?php echo $form->fileField($model->personnels,'photo',array('size'=>50,'maxlength'=>50)); ?>

		<?php echo $form->error($model->personnels,'photo'); ?>
	</div>
	<!--
	Фото
	<?php echo CHtml::fileField('photo', '', $htmlOptions=array ( )); ?>
 	-->
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->