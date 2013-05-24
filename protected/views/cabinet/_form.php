<?php
/* @var $this CabinetController */
/* @var $model Cabinet */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cabinet-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_building'); ?>
		<?php echo $form->dropDownList($model,'id_building',CHtml::listData(Building::model()->findAll(),'id','name')); ?>
		<?php echo $form->error($model,'id_building'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'num'); ?>
		<?php echo $form->textField($model,'num',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'num'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'floor'); ?>
		<?php echo $form->textField($model,'floor',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'floor'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->