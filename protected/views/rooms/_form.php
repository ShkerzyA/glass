<?php
/* @var $this RoomsController */
/* @var $model Rooms */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'rooms-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'id_cabinet'); ?>

		<?php $tmp=Cabinet::model()->findall();
echo $form->dropDownList($model,"id_cabinet",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->cname.' '.$tmp->num);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'id_cabinet'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'managers'); ?>

		<?php echo Customfields::multiPersonnel($model,'managers'); ?>

		<?php echo $form->error($model,'managers'); ?>
	</div> 

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->