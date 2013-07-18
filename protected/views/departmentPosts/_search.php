<?php
/* @var $this DepartmentPostsController */
/* @var $model DepartmentPosts */
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
		<?php echo $form->label($model,'post'); ?>
		<?php echo $form->textField($model,'post',array('size'=>60,'maxlength'=>80)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_begin'); ?>
		<?php echo $form->textField($model,'date_begin'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_end'); ?>
		<?php echo $form->textField($model,'date_end'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'islead'); ?>
		<?php echo $form->textField($model,'islead'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'kod_parus'); ?>
		<?php echo $form->textField($model,'kod_parus'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'post_subdiv_rn'); ?>
		<?php echo $form->textField($model,'post_subdiv_rn',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Искать'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->