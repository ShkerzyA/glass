<?php
/* @var $this DocsController */
/* @var $data Docs */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creator')); ?>:</b>
	<?php echo CHtml::encode($data->creator0->post); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('doc_name')); ?>:</b>
	<?php echo CHtml::encode($data->doc_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('text_docs')); ?>:</b>
	<?php echo CHtml::encode($data->text_docs); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('link')); ?>:</b>
	<?php echo CHtml::encode($data->link); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_begin')); ?>:</b>
	<?php echo CHtml::encode($data->date_begin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_end')); ?>:</b>
	<?php echo CHtml::encode($data->date_end); ?>
	<br />

	
	<b><?php echo CHtml::encode($data->getAttributeLabel('id_catalog')); ?>:</b>
	<?php echo CHtml::encode($data->idCatalog->cat_name); ?>
	<br />

	

</div>