<?php
/* @var $this EquipmentLogController */
/* @var $model EquipmentLog */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'equipment-log-form',
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
		<?php echo $form->labelEx($model,'subject'); ?>

		<?php $tmp=Personnel::model()->findall();
echo $form->dropDownList($model,"subject",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->surname);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'subject'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'object'); ?>

		<?php $tmp=Equipment::model()->findall();
echo $form->dropDownList($model,"object",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->mark);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'object'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>

		<?php echo $form->textField($model,'type'); ?>

		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'details'); ?>

		<?php echo $form->textField($model,'details',array('value'=>implode(',', $model->details))); ?>

		<?php echo $form->error($model,'details'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->