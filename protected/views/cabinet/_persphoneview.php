<?php
/* @var $this PersonnelController */
/* @var $data Personnel */
//echo '<pre>'; print_r($data); echo '</pre>';
if(!empty($data->workplaces)){
	foreach ($data->workplaces as $v) {
		if(!empty($v->idPersonnel)){
			echo '<tr><td>'.$v->phone.'</td><td><b>'.$v->idPersonnel->fio_full().'</b></td><td>'.$data->cabNameFull().'</td></tr>';
		}
	}
}


?>


<tr>
	<td><b><?php echo $data->phone ?></b></td>
	<td><b>Общий</b></td>
	<td><?php 
		$isit=(Yii::app()->user->checkAccess('inGroup',array('group'=>array('it'))));
		if($isit)
			echo '<a href="'.Yii::app()->baseUrl.'/Cabinet/'.$data->id.'">';
		echo $data->cabNameFull(); 
		if($isit)
			echo '</a>';
		?>
	</td>
	
</tr>
