<?php
/* @var $this EventsController */
/* @var $model Events */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'events-form',
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
		<?php echo $form->labelEx($model,'description'); ?>

		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>

		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'creator'); ?>

		<?php $tmp=DepartmentPosts::model()->findall();
echo $form->dropDownList($model,"creator",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->post);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'creator'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_room'); ?>

		<?php echo $form->textField($model,'id_room'); ?>

		<?php echo $form->error($model,'id_room'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'timestamp'); ?>

		<?php echo $form->textField($model,'timestamp'); ?>

		<?php echo $form->error($model,'timestamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'timestamp_end'); ?>

		<?php echo $form->textField($model,'timestamp_end'); ?>

		<?php echo $form->error($model,'timestamp_end'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'repeat'); ?>

		<?php echo $form->textField($model,'repeat'); ?>

		<?php echo $form->error($model,'repeat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>

		<?php echo $form->textField($model,'status'); ?>

		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->