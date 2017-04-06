<?php
/* @var $this ZempleavController */
/* @var $model Zempleav */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'zempleav-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'empleav_rn'); ?>

		<?php echo $form->textField($model,'empleav_rn',array('size'=>4,'maxlength'=>4)); ?>

		<?php echo $form->error($model,'empleav_rn'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ank_rn'); ?>

		<?php echo $form->textField($model,'ank_rn',array('size'=>4,'maxlength'=>4)); ?>

		<?php echo $form->error($model,'ank_rn'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>

		<?php echo $form->textField($model,'type',array('size'=>1,'maxlength'=>1)); ?>

		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'leavekind_'); ?>

		<?php echo $form->textField($model,'leavekind_',array('size'=>4,'maxlength'=>4)); ?>

		<?php echo $form->error($model,'leavekind_'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'grrbdc_rn'); ?>

		<?php echo $form->textField($model,'grrbdc_rn',array('size'=>4,'maxlength'=>4)); ?>

		<?php echo $form->error($model,'grrbdc_rn'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'startdate'); ?>

		<?php echo $form->textField($model,'startdate'); ?>

		<?php echo $form->error($model,'startdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'enddate'); ?>

		<?php echo $form->textField($model,'enddate'); ?>

		<?php echo $form->error($model,'enddate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'maindays'); ?>

		<?php echo $form->textField($model,'maindays',array('size'=>4,'maxlength'=>4)); ?>

		<?php echo $form->error($model,'maindays'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'adddays'); ?>

		<?php echo $form->textField($model,'adddays',array('size'=>3,'maxlength'=>3)); ?>

		<?php echo $form->error($model,'adddays'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'docdate'); ?>

		<?php echo $form->textField($model,'docdate'); ?>

		<?php echo $form->error($model,'docdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'docnum'); ?>

		<?php echo $form->textField($model,'docnum',array('size'=>21,'maxlength'=>21)); ?>

		<?php echo $form->error($model,'docnum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fromdate'); ?>

		<?php echo $form->textField($model,'fromdate'); ?>

		<?php echo $form->error($model,'fromdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'todate'); ?>

		<?php echo $form->textField($model,'todate'); ?>

		<?php echo $form->error($model,'todate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'storno'); ?>

		<?php echo $form->checkBox($model,'storno'); ?>

		<?php echo $form->error($model,'storno'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'kfindbs_rn'); ?>

		<?php echo $form->textField($model,'kfindbs_rn',array('size'=>4,'maxlength'=>4)); ?>

		<?php echo $form->error($model,'kfindbs_rn'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'source'); ?>

		<?php echo $form->textField($model,'source',array('size'=>1,'maxlength'=>1)); ?>

		<?php echo $form->error($model,'source'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'orgbase_rn'); ?>

		<?php $tmp=Personnel::model()->findall();
echo $form->dropDownList($model,"orgbase_rn",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->orgbase_rn);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'orgbase_rn'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'docbase_rn'); ?>

		<?php echo $form->textField($model,'docbase_rn',array('size'=>4,'maxlength'=>4)); ?>

		<?php echo $form->error($model,'docbase_rn'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'docorg_rn'); ?>

		<?php echo $form->textField($model,'docorg_rn',array('size'=>4,'maxlength'=>4)); ?>

		<?php echo $form->error($model,'docorg_rn'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'delayinlea'); ?>

		<?php echo $form->checkBox($model,'delayinlea'); ?>

		<?php echo $form->error($model,'delayinlea'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reason'); ?>

		<?php echo $form->textField($model,'reason',array('size'=>60,'maxlength'=>254)); ?>

		<?php echo $form->error($model,'reason'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->