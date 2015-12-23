<?php
/* @var $this VehiclesController */
/* @var $data Vehicles */
?>

<a href="<?php echo(Yii::app()->baseUrl.'/Vehicles/'.$data->id)?>">
<div class="view">
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('owner')); ?>:</b>
	<?php echo CHtml::encode($data->owner0->fio_full()); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mark')); ?>:</b>
	<?php echo CHtml::encode($data->markName()); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('number')); ?>:</b>
	<?php echo CHtml::encode($data->number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deactive')); ?>:</b>
	<?php echo CHtml::encode($data->isDeactive()); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->getStatus()); ?>
	<br />


</div>
</a>