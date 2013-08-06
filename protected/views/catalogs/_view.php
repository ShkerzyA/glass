<?php
/* @var $this CatalogsController */
/* @var $data Catalogs */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_parent')); ?>:</b>
	<?php echo CHtml::encode($data->catalogs->cat_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cat_name')); ?>:</b>
	<?php echo CHtml::encode($data->cat_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('owner')); ?>:</b>
	<?php echo CHtml::encode($data->owner0->post); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('groups')); ?>:</b>
	<?php echo CHtml::encode($data->groups); ?>
	<br />


</div>