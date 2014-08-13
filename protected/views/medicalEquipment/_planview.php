<?php
/* @var $this PersonnelController */
/* @var $data Personnel */
//echo '<pre>'; print_r($data); echo '</pre>';?>

<tr>
	<td><?php echo CHtml::encode($data->date); ?></td>
	<td><?php echo CHtml::encode($data->cnum); ?></td>
	<td><?php echo CHtml::encode($data->name); ?></td>
	<td><?php echo CHtml::encode($data->date_exp); ?></td>
	<td><?php echo CHtml::encode($data->number_research); ?></td>
	<td><?php echo CHtml::encode($data->name_research); ?></td>
	<td><?php echo CHtml::encode($data->fio_pac); ?></td>
	<td><?php echo CHtml::encode($data->diag); ?></td>
	<td><?php echo CHtml::encode($data->birthday); ?></td>
	<td><?php echo CHtml::encode($data->fio_sender); ?></td>
	<td><?php echo CHtml::encode($data->conclusion); ?></td>
	<td><?php echo CHtml::encode($data->eed); ?></td>
	<td><?php echo CHtml::encode($data->number_downtime); ?></td>
	<td><?php echo CHtml::encode($data->reason_downtime); ?></td>
	<td><?php echo CHtml::encode($data->measures_taken); ?></td>
</tr>

