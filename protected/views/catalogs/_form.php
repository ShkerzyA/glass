<?php
/* @var $this CatalogsController */
/* @var $model Catalogs */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerPackage('multichoise');
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

	<div class="row">
		<?php echo $form->labelEx($model,'owner'); ?>

		<?php $tmp=DepartmentPosts::model()->findall();
echo $form->dropDownList($model,"owner",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->post);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'owner'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'groups'); ?>

		<?php echo $form->textField($model,'groups'); ?>

		<?php echo $form->error($model,'groups'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->