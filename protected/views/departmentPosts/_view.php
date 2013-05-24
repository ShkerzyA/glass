<?php
/* @var $this PersonnelPostsController */
/* @var $data PersonnelPosts */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('post')); ?>:</b>
	<?php echo CHtml::encode($data->post); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_department')); ?>:</b>
	<?php echo CHtml::encode($data->id_department); ?>
	<br />


</div>