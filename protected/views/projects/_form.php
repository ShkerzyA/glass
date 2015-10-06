<?php
/* @var $this ProjectsController */
/* @var $model Projects */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'projects-form',
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
		<?php echo $form->labelEx($model,'creator'); ?>

		<?php $tmp=Personnel::model()->findall();
echo $form->dropDownList($model,"creator",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->fio());}),array('empty' => '')); ?>
		<?php echo $form->error($model,'creator'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_department'); ?>

		<?php echo $form->textField($model,'id_department'); ?>

		<?php echo $form->error($model,'id_department'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>

		<?php echo $form->textField($model,'status'); ?>

		<?php echo $form->error($model,'status'); ?>
	</div>

<div class="row">
		<?php echo $form->labelEx($model,'executors'); ?>
		<?php echo Customfields::multiPersonnel($model,'executors','add_executors'); ?>
		<?php echo $form->error($model,'executors'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'group'); ?>

				<?php $tmp=PostsGroups::model()->findall();
echo $form->dropDownList($model,"group",CHtml::listData($tmp,"group_key",function($tmp) {
				return CHtml::encode($tmp->group_name);}),array('empty' => '')); ?>

		<?php echo $form->error($model,'group'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>
	<?php echo $form->hiddenField($model,'id'); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->