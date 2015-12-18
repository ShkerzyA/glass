<?php
/* @var $this VehiclesController */
/* @var $model Vehicles */
/* @var $form CActiveForm */
?>

<style>
td input{
	width: 100%;
}
</style>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl('vehicles/setAction'),
	'method'=>'post',
)); ?>

			<?php echo $form->hiddenField($model,'id'); ?>
			<?php echo $form->hiddenField($model,'number'); ?>
			<?php echo $form->error($model,'id'); ?>
	
		<table style='width: 100%; margin: 0px;'><tr>
			<td><?php echo CHtml::submitButton('Въезд',array('name'=>'in')); ?></td>
			<td><?php echo CHtml::submitButton('Выезд',array('name'=>'out')); ?></td>
			<td><?php echo CHtml::submitButton('Отклонить',array('name'=>'deny')); ?></td>
		</tr></table>
<?php $this->endWidget(); ?>
<div>
<div style='clear: both'></div>