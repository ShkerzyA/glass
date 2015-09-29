<?php
/* @var $this PersonnelController */
/* @var $data Personnel */
//echo '<pre>'; print_r($data); echo '</pre>';?>
	
<tr>
	<?php if(!$hideRoom)
		echo '<td>'.CHtml::encode($data->idRoom->idCabinet->cname).'</td>';
	?>
		<!--<td><?php // echo CHtml::encode($data->date); ?></td>-->
	<td><?php echo CHtml::encode($data->timestamp.' - '.$data->timestamp_end); ?></td>
	<td><?php echo CHtml::encode($data->fio_pac); ?></td>
	<!--<td><?php // echo CHtml::encode($data->date_gosp); ?></td> -->
	<td><?php echo CHtml::encode($data->operator0->fio_full()); ?></td>
	<td><?php
			$exec=array();
				foreach ($data->anesthesiologists as $v){
					if(!empty($v)){
						$pers=Personnel::model()->findByPk($v);
						if(!empty($pers))
							$exec[]=CHtml::encode($pers->fio());
					}
				}	
				if(!empty($data->anesthesiologist_w))
					$exec[]='<br>анестезист: '.CHtml::encode($data->anesthesiologist_w0->fio());
				echo (implode(', ', $exec));?></td>
	<td><?php
		$exec=array();
				foreach ($data->brigade as $v){
					if(!empty($v)){
						$pers=Personnel::model()->findByPk($v);
						if(!empty($pers))
							$exec[]=CHtml::encode($pers->fio());
					}
				}
				if(!empty($data->scrub_nurse)){
					$exec[]='<br>опер. сестра: '.CHtml::encode($data->scrub_nurse0->fio());
				}	
				echo (implode(', ', $exec)); ?></td>
	<td><?php
		$exec=array();
				foreach ($data->operations as $v){
					if(!empty($v)){
						if ($oper=ListOperations::model()->findByPk($v))
							$exec[]=CHtml::encode($oper->name);
					}
				}
				echo (implode(', ', $exec)); ?></td>


	<td><?php echo CHtml::encode($data->getTypeOper('label')); ?></td>
</tr>

