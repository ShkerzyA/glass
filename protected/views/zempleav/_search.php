<?php
/* @var $this ZempleavController */
/* @var $model Zempleav */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'empleav_rn'); ?>
		<?php echo $form->textField($model,'empleav_rn',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ank_rn'); ?>
		<?php echo $form->textField($model,'ank_rn',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'type'); ?>
		<?php echo $form->textField($model,'type',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leavekind_'); ?>
		<?php echo $form->textField($model,'leavekind_',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'grrbdc_rn'); ?>
		<?php echo $form->textField($model,'grrbdc_rn',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'startdate'); ?>
		<?php echo $form->textField($model,'startdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'enddate'); ?>
		<?php echo $form->textField($model,'enddate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'maindays'); ?>
		<?php echo $form->textField($model,'maindays',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'adddays'); ?>
		<?php echo $form->textField($model,'adddays',array('size'=>3,'maxlength'=>3)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'docdate'); ?>
		<?php echo $form->textField($model,'docdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'docnum'); ?>
		<?php echo $form->textField($model,'docnum',array('size'=>21,'maxlength'=>21)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fromdate'); ?>
		<?php echo $form->textField($model,'fromdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'todate'); ?>
		<?php echo $form->textField($model,'todate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'storno'); ?>
		<?php echo $form->checkBox($model,'storno'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'kfindbs_rn'); ?>
		<?php echo $form->textField($model,'kfindbs_rn',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'source'); ?>
		<?php echo $form->textField($model,'source',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'orgbase_rn'); ?>
		<?php echo $form->textField($model,'orgbase_rn',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'docbase_rn'); ?>
		<?php echo $form->textField($model,'docbase_rn',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'docorg_rn'); ?>
		<?php echo $form->textField($model,'docorg_rn',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'delayinlea'); ?>
		<?php echo $form->checkBox($model,'delayinlea'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reason'); ?>
		<?php echo $form->textField($model,'reason',array('size'=>60,'maxlength'=>254)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Искать'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->