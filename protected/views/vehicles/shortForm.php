<?php
/* @var $this VehiclesController */
/* @var $model Vehicles */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerPackage('customfields');
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vehicles-form',
	'enableAjaxValidation'=>True,
)); ?>

	<?php echo $form->errorSummary($model); ?>


	
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



<?php $this->endWidget(); ?>

</div><!-- form -->