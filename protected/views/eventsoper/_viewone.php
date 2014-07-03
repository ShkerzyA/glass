
<?php

		$status=$model->gimmeStatus();

echo '<div class="comment " id="taskbody">
		<div style="position: relative; float: left;"><h1>'.$typeEvent.'</h1></div>
		<div style="position: relative; float: right; text-align: right"><i>('.$status['label'].') '.$model->date.' ('.$model->timestamp.'-'.$model->timestamp_end.')<br>
		Создатель:  '.$model->creator0->surname.' '.$model->creator0->name.' '.$model->creator0->patr.'</i></div>'.
		'<hr><p class="norm_text">'.$model->operation0->name.' ('.$model->getTypeOper('label').')</p>';
		?>
		<table class='bordertable'>
		<tr>
		<td><?php echo CHtml::encode($model->getAttributeLabel('id_room')); ?> </td> 
		<td><?php
   		echo CHtml::encode($model->idRoom->idCabinet->cname); ?> </td></tr>

		<tr>
   		<td><?php echo CHtml::encode($model->getAttributeLabel('date_gosp')); ?> </td> 
		<td><?php
   		echo CHtml::encode($model->date_gosp); ?> </td></tr>

   		<tr><td><?php echo CHtml::encode($model->getAttributeLabel('fio_pac')); ?> </td> 
		<td><?php
   		echo CHtml::encode($model->fio_pac); ?> </td></tr></tr>

		<tr><td><?php echo CHtml::encode($model->getAttributeLabel('operator')); ?> </td> 
		<td><?php
   		echo CHtml::encode($model->operator0->surname.' '.$model->operator0->name.' '.$model->operator0->patr); ?> </td></tr>

   		<tr><td><?php echo CHtml::encode($model->getAttributeLabel('anesthesiologist')); ?> </td> 
		<td><?php
   		echo CHtml::encode($model->anesthesiologist0->surname.' '.$model->anesthesiologist0->name.' '.$model->anesthesiologist0->patr); ?> </td></tr>


   		<tr><td><?php echo CHtml::encode($model->getAttributeLabel('brigade')); ?></td> 
   		<td><?php
   		$tmp=explode(',',$model->brigade); 
		$exec=array();
				foreach ($tmp as $v){
					if(!empty($v)){
						$pers=Personnel::model()->findByPk($v);
						$exec[]=CHtml::encode($pers->surname.' '.$pers->name);
					}
				}	
				echo (implode(', ', $exec)); ?></td></tr></table>

   	

<?php echo'</div>'; ?>