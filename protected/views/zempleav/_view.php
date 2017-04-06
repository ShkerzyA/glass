<?php
/* @var $this ZempleavController */
/* @var $data Zempleav */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('empleav_rn')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->empleav_rn), array('view', 'id'=>$data->empleav_rn)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ank_rn')); ?>:</b>
	<?php echo CHtml::encode($data->ank_rn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('leavekind_')); ?>:</b>
	<?php echo CHtml::encode($data->leavekind_); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('grrbdc_rn')); ?>:</b>
	<?php echo CHtml::encode($data->grrbdc_rn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('startdate')); ?>:</b>
	<?php echo CHtml::encode($data->startdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('enddate')); ?>:</b>
	<?php echo CHtml::encode($data->enddate); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('maindays')); ?>:</b>
	<?php echo CHtml::encode($data->maindays); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('adddays')); ?>:</b>
	<?php echo CHtml::encode($data->adddays); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('docdate')); ?>:</b>
	<?php echo CHtml::encode($data->docdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('docnum')); ?>:</b>
	<?php echo CHtml::encode($data->docnum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fromdate')); ?>:</b>
	<?php echo CHtml::encode($data->fromdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('todate')); ?>:</b>
	<?php echo CHtml::encode($data->todate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('storno')); ?>:</b>
	<?php echo CHtml::encode($data->storno); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kfindbs_rn')); ?>:</b>
	<?php echo CHtml::encode($data->kfindbs_rn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('source')); ?>:</b>
	<?php echo CHtml::encode($data->source); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('orgbase_rn')); ?>:</b>
	<?php echo CHtml::encode($data->orgbaseRn->orgbase_rn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('docbase_rn')); ?>:</b>
	<?php echo CHtml::encode($data->docbase_rn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('docorg_rn')); ?>:</b>
	<?php echo CHtml::encode($data->docorg_rn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delayinlea')); ?>:</b>
	<?php echo CHtml::encode($data->delayinlea); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reason')); ?>:</b>
	<?php echo CHtml::encode($data->reason); ?>
	<br />

	*/ ?>

</div>