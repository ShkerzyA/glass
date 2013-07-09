<?php
/* @var $this DepartmentPostsController */
/* @var $model DepartmentPosts */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'department-posts-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'post'); ?>

		<?php echo $form->textField($model,'post',array('size'=>60,'maxlength'=>80)); ?>

		<?php echo $form->error($model,'post'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_department'); ?>

		<?php $tmp=Department::model()->findall();
echo $form->dropDownList($model,"id_department",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->name);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'id_department'); ?>
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

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->