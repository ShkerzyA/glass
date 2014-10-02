<?php
/* @var $this EquipmentController */
/* @var $data Equipment */

	$status=Equipment::getStatus();
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_workplace')); ?>:</b>
	<?php echo CHtml::link($data->idWorkplace->idCabinet->idFloor->idBuilding->bname.'/'.$data->idWorkplace->idCabinet->idFloor->fname.'/'.$data->idWorkplace->idCabinet->num.' '.$data->idWorkplace->idCabinet->cname.'/'.$data->idWorkplace->wname, array('/Workplace/view/', 'id'=>$data->id_workplace)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('serial')); ?>:</b>
	<?php echo CHtml::encode($data->serial); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type0->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('producer')); ?>:</b>
	<?php echo CHtml::encode($data->producer0->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mark')); ?>:</b>
	<?php echo CHtml::encode($data->mark); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inv')); ?>:</b>
	<?php echo CHtml::encode($data->inv); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notes')); ?>:</b>
	<?php echo CHtml::encode($data->notes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($status[$data->status]); ?>
	<br />


	<?php if($data->type==3 and $data->producer==0):?>

		<a href="http://h10025.www1.hp.com/ewfrf/wc/weResults?tmp_weCountry=ru&tmp_weSerial=<?php echo $data->serial; ?>&tmp_weProduct=CE538A&cc=ru&dlc=ru&lc=ru&product=" target=_blank>Проверка гарантии</a>
	<?php endif; ?>

	<?php /*
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('notes')); ?>:</b>
	<?php echo CHtml::encode($data->notes); ?>
	<br />

	*/ ?>

</div>