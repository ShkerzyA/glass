<?php
/* @var $this MedicalEquipmentController */
/* @var $data MedicalEquipment */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cnum')); ?>:</b>
	<?php echo CHtml::encode($data->cnum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_exp')); ?>:</b>
	<?php echo CHtml::encode($data->date_exp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('number_research')); ?>:</b>
	<?php echo CHtml::encode($data->number_research); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name_research')); ?>:</b>
	<?php echo CHtml::encode($data->name_research); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('fio_pac')); ?>:</b>
	<?php echo CHtml::encode($data->fio_pac); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('diag')); ?>:</b>
	<?php echo CHtml::encode($data->diag); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('birthday')); ?>:</b>
	<?php echo CHtml::encode($data->birthday); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fio_sender')); ?>:</b>
	<?php echo CHtml::encode($data->fio_sender); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('conclusion')); ?>:</b>
	<?php echo CHtml::encode($data->conclusion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('number_downtime')); ?>:</b>
	<?php echo CHtml::encode($data->number_downtime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('eed')); ?>:</b>
	<?php echo CHtml::encode($data->eed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reason_downtime')); ?>:</b>
	<?php echo CHtml::encode($data->reason_downtime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('measures_taken')); ?>:</b>
	<?php echo CHtml::encode($data->measures_taken); ?>
	<br />

	*/ ?>

</div>