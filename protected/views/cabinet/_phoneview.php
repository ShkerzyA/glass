<?php
/* @var $this PersonnelController */
/* @var $data Personnel */
//echo '<pre>'; print_r($data); echo '</pre>';
$num=1;
$res='';
if(!empty($data->workplaces)){
	foreach ($data->workplaces as $v) {
		if(!empty($v->phone) or !empty($v->id_personnel)){
			$num++;
			$res.='<tr><td>'.$v->phone.'</td><td><b>'.$v->wpName(false,'fio_full').'</b></td></tr>';
		}
	}
}


?>


<tr >
	<td class=nob><b><?php echo $data->phone ?></b></td>
	<td class=nob></td>
	<td class=nob rowspan=<?php echo $num; ?>><?php 
		$isit=(Yii::app()->user->checkAccess('inGroup',array('group'=>array('it'))));
		if($isit)
			echo '<a href="'.Yii::app()->baseUrl.'/Cabinet/'.$data->id.'">';
		echo $data->cabNameFull(); 
		if($isit)
			echo '</a>';
		?>
	</td>
</tr>
<?php echo $res; ?>
