<?php 
	$last_stat='no';
 	$i=0;
?>
<?php foreach ($model as $v): ?>
			<?php $status=$v->status0; 
		if($last_stat!=$status['label']){
			$i++;
			echo "<h4 id=".$status['id']." class='subscribe hideT ".$status['css_status']."'>".$status['label']."</h4><hr>";
			$last_stat=$status['label'];
		} 
			echo '<div><div style="float: right"><a href=/glass/tasks/bindTasks?id='.$id.'&&idBinded='.$v->id.'><img src="'.Yii::app()->request->baseUrl.'/images/chain24.png" title="Привязать"></a></div><div style="float: right; width: 90%;">';
			$this->renderPartial('/tasks/taskpanel',array('status'=>$status,'data'=>$v),false,false);
			echo'</div></div><div class="clear"></div>';
		?>

	
<?php endforeach; ?>