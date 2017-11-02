<?php
/* @var $this PersProgramController */
/* @var $model PersProgram */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pers-program-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'id_program'); ?>

		<?php $tmp=Programs3p::model()->findall();
echo $form->dropDownList($model,"id_program",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->id_program);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'id_program'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_pers'); ?>

		<?php $tmp=Personnel::model()->findall();
echo $form->dropDownList($model,"id_pers",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->id_pers);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'id_pers'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'login'); ?>

		<?php echo $form->textField($model,'login',array('size'=>60,'maxlength'=>100)); ?>

		<?php echo $form->error($model,'login'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->