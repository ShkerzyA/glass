<?php
/* @var $this DepartmentPostsController */
/* @var $data DepartmentPosts */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('post')); ?>:</b>
	<?php echo CHtml::encode($data->post); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_begin')); ?>:</b>
	<?php echo CHtml::encode($data->date_begin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_end')); ?>:</b>
	<?php echo CHtml::encode($data->date_end); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('islead')); ?>:</b>
	<?php echo CHtml::encode($data->islead); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kod_parus')); ?>:</b>
	<?php echo CHtml::encode($data->kod_parus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('post_subdiv_rn')); ?>:</b>
	<?php echo CHtml::encode($data->postSubdivRn->name); ?>
	<br />


</div>