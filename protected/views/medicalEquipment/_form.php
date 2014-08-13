<?php
/* @var $this MedicalEquipmentController */
/* @var $model MedicalEquipment */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'medical-equipment-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>

		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
   'name' => 'date',
   'model' => $model,
   'attribute' => 'date',
   'language' => 'ru',
   'options' => array(
       'showAnim' => 'fold',
   ),
   'htmlOptions' => array(
       'style' => 'height:20px;'
   ),
));?>


		<?php echo $form->error($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cnum'); ?>

		<?php echo $form->textField($model,'cnum'); ?>

		<?php echo $form->error($model,'cnum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>

		<?php echo $form->textField($model,'name'); ?>

		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_exp'); ?>

		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
   'name' => 'date_exp',
   'model' => $model,
   'attribute' => 'date_exp',
   'language' => 'ru',
   'options' => array(
       'showAnim' => 'fold',
   ),
   'htmlOptions' => array(
       'style' => 'height:20px;'
   ),
));?>

		<?php echo $form->error($model,'date_exp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'number_research'); ?>

		<?php echo $form->textField($model,'number_research'); ?>

		<?php echo $form->error($model,'number_research'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name_research'); ?>

		<?php echo $form->textField($model,'name_research'); ?>

		<?php echo $form->error($model,'name_research'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fio_pac'); ?>

		<?php echo $form->textField($model,'fio_pac'); ?>

		<?php echo $form->error($model,'fio_pac'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'diag'); ?>

		<?php echo $form->textArea($model,'diag',array('rows'=>6, 'cols'=>50)); ?>

		<?php echo $form->error($model,'diag'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'birthday'); ?>

		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
   'name' => 'birthday',
   'model' => $model,
   'attribute' => 'birthday',
   'language' => 'ru',
   'options' => array(
       'showAnim' => 'fold',
   ),
   'htmlOptions' => array(
       'style' => 'height:20px;'
   ),
));?>

		<?php echo $form->error($model,'birthday'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fio_sender'); ?>

		<?php echo $form->textField($model,'fio_sender'); ?>

		<?php echo $form->error($model,'fio_sender'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'conclusion'); ?>

		<?php echo $form->textArea($model,'conclusion',array('rows'=>6, 'cols'=>50)); ?>

		<?php echo $form->error($model,'conclusion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'number_downtime'); ?>

		<?php echo $form->textField($model,'number_downtime'); ?>

		<?php echo $form->error($model,'number_downtime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'eed'); ?>

		<?php echo $form->textField($model,'eed'); ?>

		<?php echo $form->error($model,'eed'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reason_downtime'); ?>

		<?php echo $form->textField($model,'reason_downtime'); ?>

		<?php echo $form->error($model,'reason_downtime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'measures_taken'); ?>

		<?php echo $form->textField($model,'measures_taken'); ?>

		<?php echo $form->error($model,'measures_taken'); ?>
	</div>


<?php $this->endWidget(); ?>

</div><!-- form -->