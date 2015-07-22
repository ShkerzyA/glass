<?php
/* @var $this CallLogController */
/* @var $data CallLog */
?>
 	<tr >

		<td><?php echo $data->calling_number; ?></td>
		<td><?php echo $data->timestamp; ?></td>
		<td><?php echo $data->code; ?></td>
		<td><?php echo $data->direction; ?></td>
		<td><?php echo $data->called_number; ?></td>
		<td><?php echo $data->duration; ?></td>
		<td><?php echo $data->cost; ?></td>
	</tr>


