<?php
/* @var $this TasksStatusController */
/* @var $data TasksStatus */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('label')); ?>:</b>
	<?php echo CHtml::encode($data->label); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('css_class')); ?>:</b>
	<?php echo CHtml::encode($data->css_class); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('css_status')); ?>:</b>
	<?php echo CHtml::encode($data->css_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sort')); ?>:</b>
	<?php echo CHtml::encode($data->sort); ?>
	<br />


</div>