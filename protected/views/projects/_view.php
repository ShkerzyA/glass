<?php
/* @var $this ProjectsController */
/* @var $data Projects */
?>

<div class="view">


	
	<div style="float: left"><?php echo $data->ico() ?></div><h1> <?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->id)); ?></h1>
	

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	
	<b>Активен</b> ОТ: <?php echo Custom::short_date($data->timestamp); ?> ДО:<?php echo Custom::short_date($data->timestamp_end); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('creator')); ?>:</b>
	<?php echo CHtml::encode($data->creator0->fio()); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('group')); ?>:</b>
	<?php foreach ($data->group as $v){
		echo $v;
	} ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('executors')); ?>:</b>
	<?php foreach ($data->findExecutors() as $v){
		echo $v->fio().';';
	} ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('id_department')); ?>:</b>
	<?php echo CHtml::encode($data->id_department); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('executors')); ?>:</b>
	<?php echo CHtml::encode($data->executors); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('group')); ?>:</b>
	<?php echo CHtml::encode($data->group); ?>
	<br />

	*/ ?>

</div>