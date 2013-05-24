<?php
/* @var $this PersonnelController */
/* @var $model Personnel */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	'id'=>'personnel-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'surname'); ?>
		<?php echo $form->textField($model,'surname',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'surname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'patr'); ?>
		<?php echo $form->textField($model,'patr',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'patr'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'photo'); ?>
		<?php echo $form->fileField($model,'photo',array('size'=>50,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'photo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_user'); ?>
		<?php echo $form->dropDownList($model,'id_user',CHtml::listData(Users::model()->findall(),'id','username'),array('empty' => '(Привязать пользователя)')); ?>
		<?php echo $form->error($model,'id_user'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_cabinet'); ?>
		<?php echo $form->dropDownList($model,'id_cabinet',CHtml::listData(Cabinet::model()->findall(),'id','name'),array('empty' => '(Кабинет)')); ?>
		<?php echo $form->error($model,'id_cabinet'); ?>
	</div>



	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->