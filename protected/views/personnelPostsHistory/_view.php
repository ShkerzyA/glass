<?php
/* @var $this PersonnelPostsHistoryController */
/* @var $data PersonnelPostsHistory */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_personnel')); ?>:</b>
	<?php echo CHtml::encode($data->id_personnel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_post')); ?>:</b>
	<?php echo CHtml::encode($data->id_post); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_begin')); ?>:</b>
	<?php echo CHtml::encode($data->date_begin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_end')); ?>:</b>
	<?php echo CHtml::encode($data->date_end); ?>
	<br />


</div>