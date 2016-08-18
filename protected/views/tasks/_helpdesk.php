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
		$this->renderPartial('taskpanel',array('status'=>$status,'v'=>$v),false,false);
		?>

	
<?php endforeach; ?>