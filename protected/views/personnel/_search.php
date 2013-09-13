<?php
/* @var $this PersonnelController */
/* @var $model Personnel */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>



	<div class="inline">
		<?php echo $form->label($model,'surname'); ?>
		<?php echo $form->textField($model,'surname',array('size'=>50,'maxlength'=>50)); ?>
	</div>
	<div class="inline">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
	</div>
	<div class="inline">
		<?php echo $form->label($model,'patr'); ?>
		<?php echo $form->textField($model,'patr',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="inline">
		<?php echo $form->label($model,'departments_name'); ?>
		<?php echo $form->textField($model,'departments_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Поиск'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->