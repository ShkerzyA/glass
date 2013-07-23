<?php
/* @var $this FloorController */
/* @var $data Floor */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_building')); ?>:</b>
	<?php echo CHtml::encode($data->idBuilding->bname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fnum')); ?>:</b>
	<?php echo CHtml::encode($data->fnum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fname')); ?>:</b>
	<?php echo CHtml::encode($data->fname); ?>
	<br />


</div>