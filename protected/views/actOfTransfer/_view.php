<?php
/* @var $this ActOfTransferController */
/* @var $data ActOfTransfer */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timestamp')); ?>:</b>
	<?php echo CHtml::encode($data->timestamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transferring')); ?>:</b>
	<?php echo CHtml::encode($data->transferring); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('receiving')); ?>:</b>
	<?php echo CHtml::encode($data->receiving); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('receiving_var')); ?>:</b>
	<?php echo CHtml::encode($data->receiving_var); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creator')); ?>:</b>
	<?php echo CHtml::encode($data->creator); ?>
	<br />


</div>