<?php
/* @var $this DocsController */
/* @var $model Docs */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'docs-form',
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

<?php if((Yii::app()->user->role=='administrator') and ($model->scenario!='insert')): ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'creator'); ?>


		<?php echo Customfields::searchPersonnel($model,'creator'); ?>
		<?php echo $form->error($model,'creator'); ?>
	</div>




	<div class="row">
		<?php echo $form->labelEx($model,'id_catalog'); ?>

		<?php $tmp=Catalogs::model()->findall();
echo $form->dropDownList($model,"id_catalog",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->cat_name);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'id_catalog'); ?>
	</div>

<?php endif; ?>

	<div class="row">
		<?php echo $form->labelEx($model,'doc_name'); ?>

		<?php echo $form->textField($model,'doc_name',array('size'=>60,'maxlength'=>100)); ?>

		<?php echo $form->error($model,'doc_name'); ?>
	</div>
	<?php echo Custom::attachFileField($model); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'text_docs'); ?>

		<?php echo $form->textArea($model,'text_docs',array('rows'=>6, 'cols'=>50)); ?>

		<?php echo $form->error($model,'text_docs'); ?>
	</div>

 <!--
	<div class="row">
		<?php echo $form->labelEx($model,'link'); ?>

		<?php echo $form->fileField($model,'link',array('size'=>60,'maxlength'=>100,'multiple'=>True)); ?>

		<?php echo $form->error($model,'link'); ?>
	</div>  -->

	<?php 
	echo $form->labelEx($model, 'link');
$this->widget('CMultiFileUpload', array(
  'model' => $model,
  'attribute' => 'link',
  'accept' => '*',
  'duplicate' => 'Этот файл уже выбран!',
  'denied' => 'Недопустимый тип файла',
  'htmlOptions' => array(
    'multiple' => 'multiple',
  ),
));

if ($model->link) {
   echo $form->labelEx($model,'dellink');
   $this->renderPartial('_files_form',array('model'=>$model),false,false);
}
?>

<?php if((Yii::app()->user->role=='administrator') and ($model->scenario!='insert')): ?>

	<div class="row">
		<?php echo $form->labelEx($model,'date_begin'); ?>

		<?php echo $form->textField($model,'date_begin'); ?>

		<?php echo $form->error($model,'date_begin'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_end'); ?>

		<?php echo $form->textField($model,'date_end'); ?>

		<?php echo $form->error($model,'date_end'); ?>
	</div>

<?php endif; ?>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->