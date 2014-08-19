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
	<td><?php echo CHtml::encode($data->operator0->surname.' '.$data->operator0->name.' '.$data->operator0->patr); ?></td>
	<td><?php
   		$tmp=explode(',',$data->anesthesiologists); 
		$exec=array();
				foreach ($tmp as $v){
					if(!empty($v)){
						$pers=Personnel::model()->findByPk($v);
						$exec[]=CHtml::encode($pers->surname.' '.$pers->name);
					}
				}	
				if(!empty($data->anesthesiologist_w))
					$exec[]=CHtml::encode($data->anesthesiologist_w0->surname.' '.$data->anesthesiologist_w0->name);
				echo (implode(', ', $exec)); ?></td>
	<td><?php
   		$tmp=explode(',',$data->brigade); 
		$exec=array();
				foreach ($tmp as $v){
					if(!empty($v)){
						$pers=Personnel::model()->findByPk($v);
						$exec[]=CHtml::encode($pers->surname.' '.$pers->name);
					}
				}
				if(!empty($data->scrub_nurse)){
					$exec[]=CHtml::encode($data->scrub_nurse0->surname.' '.$data->scrub_nurse0->name);
				}	
				echo (implode(', ', $exec)); ?></td>
	<td><?php echo  CHtml::encode($data->operation0->name); ?></td>
	<td><?php echo CHtml::encode($data->getTypeOper('label')); ?></td>
</tr>

