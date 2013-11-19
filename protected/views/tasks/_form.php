<?php
/* @var $this TasksController */
/* @var $model Tasks */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tasks-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'tname'); ?>

		<?php echo $form->textField($model,'tname',array('size'=>60,'maxlength'=>100)); ?>

		<?php echo $form->error($model,'tname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ttext'); ?>

		<?php echo $form->textArea($model,'ttext',array('rows'=>6, 'cols'=>50)); ?>

		<?php echo $form->error($model,'ttext'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_begin'); ?>

		<?php echo $form->textField($model,'date_begin'); ?>

		<?php echo $form->error($model,'date_begin'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_end'); ?>

		<?php echo $form->textField($model,'date_end'); ?>

		<?php echo $form->error($model,'date_end'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>

		<?php echo $form->textField($model,'type'); ?>

		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'creator'); ?>

		<?php $tmp=DepartmentPosts::model()->findall();
echo $form->dropDownList($model,"creator",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->creator);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'creator'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'executor'); ?>

		<?php $tmp=DepartmentPosts::model()->findall();
echo $form->dropDownList($model,"executor",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->executor);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'executor'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->