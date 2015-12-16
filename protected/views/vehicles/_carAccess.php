<?php
/* @var $this VehiclesController */
/* @var $model Vehicles */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl('vehicles/setAction'),
	'method'=>'post',
)); ?>

		<div class="row">
			<?php echo $form->hiddenField($model,'id'); ?>
			<?php echo $form->error($model,'id'); ?>
		</div>
		<div class="row">
		<table style='width: 100%'><tr>
			<td><?php echo CHtml::submitButton('Въезд',array('name'=>'in')); ?></td>
			<td><?php echo CHtml::submitButton('Выезд',array('name'=>'out')); ?></td>
			<td><?php echo CHtml::submitButton('Отклонить',array('name'=>'deny')); ?></td>
		</tr></table>
		</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
<div style='clear: both'></div>