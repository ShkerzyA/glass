<?php
/* @var $this EquipmentController */
/* @var $data Equipment */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_workplace')); ?>:</b>
	<?php echo CHtml::encode($data->idWorkplace->id_workplace); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('serial')); ?>:</b>
	<?php echo CHtml::encode($data->serial); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('producer')); ?>:</b>
	<?php echo CHtml::encode($data->producer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mark')); ?>:</b>
	<?php echo CHtml::encode($data->mark); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inv')); ?>:</b>
	<?php echo CHtml::encode($data->inv); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notes')); ?>:</b>
	<?php echo CHtml::encode($data->notes); ?>
	<br />

	*/ ?>

</div>