<?php
/* @var $this TasksController */
/* @var $data Tasks */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tname')); ?>:</b>
	<?php echo CHtml::encode($data->tname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ttext')); ?>:</b>
	<?php echo CHtml::encode($data->ttext); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_begin')); ?>:</b>
	<?php echo CHtml::encode($data->date_begin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_end')); ?>:</b>
	<?php echo CHtml::encode($data->date_end); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creator')); ?>:</b>
	<?php echo CHtml::encode($data->creator0->creator); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('executor')); ?>:</b>
	<?php echo CHtml::encode($data->executor0->executor); ?>
	<br />

	*/ ?>

</div>