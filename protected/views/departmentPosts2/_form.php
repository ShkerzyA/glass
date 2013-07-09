<?php
/* @var $this PersonnelPostsController */
/* @var $model PersonnelPosts */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'personnel-posts-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'post'); ?>
		<?php echo $form->textField($model,'post',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'post'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_department'); ?>
		<?php echo $form->dropDownList($model,'id_department',CHtml::listData(Department::model()->findall(),'id','name')); ?>
		<?php echo $form->error($model,'id_department'); ?>
	</div>

		<div class="row">
		<?php echo $form->labelEx($model,'date_begin'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
   'name' => 'date_begin',
   'model' => $model,
   'attribute' => 'date_begin',
   'language' => 'ru',
   'options' => array(
       'showAnim' => 'fold',
   ),
   'htmlOptions' => array(
       'style' => 'height:20px;'
   ),
));?>
		<?php echo $form->error($model,'date_begin'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_end'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
   'name' => 'date_end',
   'model' => $model,
   'attribute' => 'date_end',
   'language' => 'ru',
   'options' => array(
       'showAnim' => 'fold',
   ),
   'htmlOptions' => array(
       'style' => 'height:20px;'
   ),
));?>
		<?php echo $form->error($model,'date_end'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->