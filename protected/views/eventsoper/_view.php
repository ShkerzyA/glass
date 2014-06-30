<?php
/* @var $this EventsoperController */
/* @var $data Eventsoper */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_room')); ?>:</b>
	<?php echo CHtml::encode($data->idRoom->id_room); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timestamp')); ?>:</b>
	<?php echo CHtml::encode($data->timestamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timestamp_end')); ?>:</b>
	<?php echo CHtml::encode($data->timestamp_end); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fio_pac')); ?>:</b>
	<?php echo CHtml::encode($data->fio_pac); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creator')); ?>:</b>
	<?php echo CHtml::encode($data->creator0->creator); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('operator')); ?>:</b>
	<?php echo CHtml::encode($data->operator0->operator); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_gosp')); ?>:</b>
	<?php echo CHtml::encode($data->date_gosp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('brigade')); ?>:</b>
	<?php echo CHtml::encode($data->brigade); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('anesthesiologist')); ?>:</b>
	<?php echo CHtml::encode($data->anesthesiologist0->anesthesiologist); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('operation')); ?>:</b>
	<?php echo CHtml::encode($data->operation0->operation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type_operation')); ?>:</b>
	<?php echo CHtml::encode($data->type_operation); ?>
	<br />

	*/ ?>

</div>