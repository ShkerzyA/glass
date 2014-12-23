<?php
/* @var $this PersonnelController */
/* @var $data Personnel */
//echo '<pre>'; print_r($data); echo '</pre>';
$num=1;
$res='';
if(!empty($data->workplaces)){
	foreach ($data->workplaces as $v) {
		if(!empty($v->idPersonnel)){
			$num++;
			$res.='<tr><td>'.implode(' ', $v->idPersonnel->posts()).'/<b>'.$v->idPersonnel->fio_full().'</b></td><td>'.$v->phone.'</td></tr>';
		}
	}
}


?>


<tr>
	<td rowspan=<?php echo $num; ?>><?php 
		$isit=(Yii::app()->user->checkAccess('inGroup',array('group'=>'it')));
		if($isit)
			echo '<a href="'.Yii::app()->baseUrl.'/Cabinet/'.$data->id.'">';
		echo $data->cabNameFull(); 
		if($isit)
			echo '</a>';
		?>
	</td>
	<td><b>Общий</b></td>
	<td><b><?php echo $data->phone ?><b></td>
</tr>
<?php echo $res; ?>
