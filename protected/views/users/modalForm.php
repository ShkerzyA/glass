<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

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
		<?php echo $form->labelEx($model,'id_post'); ?>

		<?php $tmp=UsersPosts::model()->findall();
echo $form->dropDownList($model,"id_post",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->post);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'id_post'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->