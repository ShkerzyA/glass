<?php
/* @var $this DepartmentController */
/* @var $model Department */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'department-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'id_parent'); ?>

		<?php $tmp=Department::model()->findall();
				echo $form->dropDownList($model,"id_parent",CHtml::listData($tmp,"id",function($tmp) {
                return CHtml::encode($tmp->name);}),array('empty' => '')); ?>
        <?php echo $form->error($model,'id_parent'); ?>

		<?php echo $form->error($model,'id_parent'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>

		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>

		<?php echo $form->error($model,'name'); ?>
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