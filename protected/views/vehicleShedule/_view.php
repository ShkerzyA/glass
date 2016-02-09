<?php
/* @var $this VehicleSheduleController */
/* @var $data VehicleShedule */
?>

<a href="<?php echo(Yii::app()->baseUrl.'/VehicleShedule/'.$data->id)?>">
<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_begin')); ?>:</b>
	<?php echo CHtml::encode($data->date_begin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_end')); ?>:</b>
	<?php echo CHtml::encode($data->date_end); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timestamp')); ?>:</b>
	<?php echo CHtml::encode($data->timestamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timestamp_end')); ?>:</b>
	<?php echo CHtml::encode($data->timestamp_end); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creator')); ?>:</b>
	<?php echo CHtml::encode($data->creator0->wrapFio('fio_full')); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('week')); ?>:</b>
	<?php echo CHtml::encode($data->DaysOfWeek()); ?>
	<br />
	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('holydays')); ?>:</b>
	<?php echo CHtml::encode($data->holydays); ?>
	<br />

	*/ ?>

</div>
</a>