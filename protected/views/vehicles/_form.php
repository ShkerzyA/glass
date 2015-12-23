<?php
/* @var $this VehiclesController */
/* @var $model Vehicles */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerPackage('customfields');
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vehicles-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'owner'); ?>

		<?php echo Customfields::searchPersonnel($model,'owner'); ?>

		<?php echo $form->error($model,'owner'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'mark'); ?>

		<?php echo $form->textField($model,'mark',array('size'=>60,'value'=>$model->markName(),'maxlength'=>200,'class'=>'vehiclemarksearch','autocomplete'=>"off")); ?>
		<?php echo $form->hiddenField($model,'mark',array('id'=>'hiddenMark')); ?>

		<?php echo $form->error($model,'mark'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'number'); ?>

		<?php //echo $form->textField($model,'number',array('size'=>10,'maxlength'=>10)); ?>

		<?php /*
			$this->widget('CMaskedTextField', array(
			'model' => $model,// модель
			'attribute' => 'number', // атрибут модели
			'mask' => '*999**99?9', // маска ввода
			'placeholder'=>'*',
			'htmlOptions' => array('size' => 10)
		)); */
		?>
		<?php echo $form->textField($model,'number',array('size'=>10,'maxlength'=>10,'placeholder'=>'X000XX000')); ?>

		<?php echo $form->error($model,'number'); ?>
	</div>



	<div class="row">
		<?php echo $form->labelEx($model,'deactive'); ?>

		<?php echo $form->checkBox($model,'deactive'); ?>

		<?php echo $form->error($model,'deactive'); ?>
	</div>

	<!--
	<div class="row">
		<?php // echo $form->labelEx($model,'status'); ?>

		<?php // echo $form->dropDownList($model,"status",Vehicles::$status,array('empty' => '')); ?>

		<?php // echo $form->error($model,'status'); ?>
	</div> -->

	<div class="row">
		<?php echo $form->labelEx($model,'shedule'); ?>

		<?php echo Customfields::searchShedule($model,'shedule'); ?>

		<?php echo $form->error($model,'shedule'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->