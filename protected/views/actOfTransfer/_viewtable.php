<tr>
	<td><?php echo CHtml::link(CHtml::encode($data->timestamp),array('/actOfTransfer','view'=>$data->id)); ?></td>
	<td><?php echo CHtml::encode($data->getStatus()); ?></td>
	<td><?php echo CHtml::encode($data->getTransferring()); ?></td>
	<td><?php echo CHtml::encode($data->getReceiving()); ?></td>
	<td><?php echo CHtml::encode($data->creator0->fio_full()); ?></td>
<tr>