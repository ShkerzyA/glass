<?php
/* @var $this FloorController */
/* @var $model Floor */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'floor-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'id_building'); ?>

		<?php $tmp=Building::model()->findall();
echo $form->dropDownList($model,"id_building",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->name.' '.$tmp->adress);})); ?>
		<?php echo $form->error($model,'id_building'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>

		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>

		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'num'); ?>

		<?php echo $form->textField($model,'num',array('size'=>10,'maxlength'=>10)); ?>

		<?php echo $form->error($model,'num'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->