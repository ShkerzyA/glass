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
				return CHtml::encode($tmp->bname);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'id_building'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fnum'); ?>

		<?php echo $form->textField($model,'fnum',array('size'=>10,'maxlength'=>10)); ?>

		<?php echo $form->error($model,'fnum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fname'); ?>

		<?php echo $form->textField($model,'fname'); ?>

		<?php echo $form->error($model,'fname'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->