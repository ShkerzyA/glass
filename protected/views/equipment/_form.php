<?php
/* @var $this EquipmentController */
/* @var $model Equipment */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'equipment-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'id_workplace'); ?>

		<?php $tmp=Workplace::model()->findall();
echo $form->dropDownList($model,"id_workplace",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->idCabinet->cname.'/'.$tmp->wname);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'id_workplace'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'serial'); ?>

		<?php echo $form->textField($model,'serial',array('size'=>60,'maxlength'=>100)); ?>

		<?php echo $form->error($model,'serial'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ename'); ?>

		<?php echo $form->textField($model,'ename',array('size'=>60,'maxlength'=>100)); ?>

		<?php echo $form->error($model,'ename'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->