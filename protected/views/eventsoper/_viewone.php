
<?php

echo '<div class="comment " id="taskbody">
		<div style="position: relative; float: left;"><h3><u>'.$model->operation0->name.'</u></h3></div>
		<div style="position: relative; float: right; text-align: right"><i>'.$model->date.' ('.$model->timestamp.'-'.$model->timestamp_end.')<br>
		Создатель:  '.$model->creator0->surname.' '.$model->creator0->name.' '.$model->creator0->patr.'</i></div>'.
		'<hr><p class="norm_text"><pre>'.$model->operation0->name.'</pre></p>';
		?>

		<dt><?php echo CHtml::encode($model->getAttributeLabel('operator')); ?> </dt> 
		<dd><?php
   		echo CHtml::encode($model->operator0->surname.' '.$model->operator0->name.' '.$model->operator0->patr); ?> </dd>

   		<dt><?php echo CHtml::encode($model->getAttributeLabel('anesthesiologist')); ?> </dt> 
		<dd><?php
   		echo CHtml::encode($model->anesthesiologist0->surname.' '.$model->anesthesiologist0->name.' '.$model->anesthesiologist0->patr); ?> </dd>


   		<dt><?php echo CHtml::encode($model->getAttributeLabel('brigade')); ?></dt> 
   		<dd><?php
   		$tmp=explode(',',$model->brigade); 
		$exec=array();
				foreach ($tmp as $v){
					if(!empty($v)){
						$pers=Personnel::model()->findByPk($v);
						$exec[]=CHtml::encode($pers->surname.' '.$pers->name);
					}
				}	
				echo (implode(', ', $exec)); ?></dd>

   	

<?php echo'</div>'; ?>