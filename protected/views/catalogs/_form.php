<?php
/* @var $this CatalogsController */
/* @var $model Catalogs */
/* @var $form CActiveForm */


?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'catalogs-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'id_parent'); ?>

		<?php $tmp=Catalogs::model()->findall();
echo $form->dropDownList($model,"id_parent",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->cat_name);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'id_parent'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cat_name'); ?>

		<?php echo $form->textField($model,'cat_name',array('size'=>60,'maxlength'=>100)); ?>

		<?php echo $form->error($model,'cat_name'); ?>
	</div>


<?php if($model->scenario!='insert'):?>
	<div class="row">
		<?php echo $form->labelEx($model,'owner'); ?>

		<?php 
			$tmp=Personnel::model()->findall();
			echo $form->dropDownList($model,"owner",CHtml::listData($tmp,"id",function($tmp) {
			return CHtml::encode($tmp->surname.' '.$tmp->name.' '.$tmp->patr);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'owner'); ?>
	</div>

<?php endif; ?>

	<div class="row">
		<?php echo $form->labelEx($model,'groups'); ?>
		<?php echo Multichoise::getField($model); ?>
		<?php echo $form->error($model,'groups'); ?>
	</div>

	<br>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->