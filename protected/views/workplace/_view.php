<?php
/* @var $this WorkplaceController */
/* @var $data Workplace */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_cabinet')); ?>:</b>
	<?php echo CHtml::encode($data->idCabinet->cname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_personnel')); ?>:</b>
	<?php echo CHtml::encode($data->idPersonnel->surname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wname')); ?>:</b>
	<?php echo CHtml::encode($data->wname); ?>
	<br />



</div>