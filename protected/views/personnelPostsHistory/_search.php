<?php
/* @var $this PersonnelPostsHistoryController */
/* @var $model PersonnelPostsHistory */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_personnel'); ?>
		<?php echo $form->textField($model,'id_personnel'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_post'); ?>
		<?php echo $form->textField($model,'id_post'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_begin'); ?>
		<?php echo $form->textField($model,'date_begin'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_end'); ?>
		<?php echo $form->textField($model,'date_end'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->