<?php
/* @var $this VehicleSheduleController */
/* @var $data VehicleShedule */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

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
	<?php echo CHtml::encode($data->creator0->fio_full()); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('week')); ?>:</b>
	<?php // echo CHtml::encode($data->week); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('weekdays')); ?>:</b>
	<?php echo CHtml::encode($data->weekdays); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('holydays')); ?>:</b>
	<?php echo CHtml::encode($data->holydays); ?>
	<br />

	*/ ?>

</div>