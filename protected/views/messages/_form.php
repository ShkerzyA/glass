<?php
/* @var $this MessagesController */
/* @var $model Messages */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'messages-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'ttext'); ?>

		<?php echo $form->textArea($model,'ttext',array('rows'=>6, 'cols'=>50)); ?>

		<?php echo $form->error($model,'ttext'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'timestamp'); ?>

		<?php echo $form->textField($model,'timestamp'); ?>

		<?php echo $form->error($model,'timestamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>

		<?php echo $form->textField($model,'type'); ?>

		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'creator'); ?>

		<?php $tmp=Personnel::model()->findall();
echo $form->dropDownList($model,"creator",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->creator);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'creator'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'users'); ?>

		<?php echo $form->textField($model,'users'); ?>

		<?php echo $form->error($model,'users'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'groups'); ?>

		<?php echo $form->textField($model,'groups'); ?>

		<?php echo $form->error($model,'groups'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'departments'); ?>

		<?php echo $form->textField($model,'departments'); ?>

		<?php echo $form->error($model,'departments'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->