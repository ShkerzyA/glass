<?php
/* @var $this RoomsController */
/* @var $data Rooms */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_cabinet')); ?>:</b>
	<?php echo CHtml::encode($data->idCabinet->id_cabinet); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('managers')); ?>:</b>
	<?php echo CHtml::encode($data->managers); ?>
	<br />


</div>