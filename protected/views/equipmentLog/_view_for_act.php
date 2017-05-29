<?php
/* @var $this EquipmentLogController */
/* @var $data EquipmentLog */

?>

<!-- <div class="view"> -->
 	<tr class='t<?php echo $data->type; ?>'>
		<td><?php echo $data->timestamp; ?></td>
		<td><?php echo $data->subject0->fio(); ?></td>
		<td><?php echo $obj=(!empty($data->objectEq))?$data->objectEq->inv." ".$data->objectEq->mark." (".$data->objectEq->serial.")":""?></td>
		<td><?php echo $data->getType()["name"] ?></td>
		<td><?php echo $data->details_full(); ?></td>
		<td><input type=checkbox style="width: 10px;" name=ActOfTransfer[equipments][] value=<?php echo $data->objectEq->id ?>></td>

	</tr>
<!-- </div> -->