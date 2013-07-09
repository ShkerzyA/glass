<?php
/* @var $this CabinetController */
/* @var $model Cabinet */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cabinet-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'id_floor'); ?>

		<?php $tmp=Floor::model()->findall();
echo $form->dropDownList($model,"id_floor",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->idBuilding->bname.'/'.$tmp->fname);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'id_floor'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cname'); ?>

		<?php echo $form->textField($model,'cname',array('size'=>50,'maxlength'=>50)); ?>

		<?php echo $form->error($model,'cname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'num'); ?>

		<?php echo $form->textField($model,'num',array('size'=>10,'maxlength'=>10)); ?>

		<?php echo $form->error($model,'num'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>

		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>100)); ?>

		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->