<?php
/* @var $this PersonnelPostsHistoryController */
/* @var $model PersonnelPostsHistory */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>CController::createUrl('PersonnelPostsHistory/Create'),
	'id'=>'personnel-posts-history-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_personnel'); 
		$personnels=Personnel::model()->findByPk($id);

		$pers=$personnels->surname.' '.$personnels->name.' '.$personnels->patr;

		echo $form->hiddenField($model,'id_personnel',array('value'=>$id,'size'=>50,'maxlength'=>50));
		echo $pers;

		?>
		<?php echo $form->error($model,'id_personnel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_post'); ?>

		<?php echo $form->dropDownList($model,'id_post',CHtml::listData(DepartmentPosts::model()->findall(),'id','post')); ?>
		<?php echo $form->error($model,'id_post'); ?>
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