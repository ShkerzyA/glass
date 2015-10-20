<?php $last_stat='no';?>
<?php foreach ($model as $v): ?>
			<?php $status=$v->status0; 
		if($last_stat!=$status['label']){
			echo "<h4 class='subscribe'>".$status['label']."</h4><hr>";
			$last_stat=$status['label'];
		} 
		$this->renderPartial('taskpanel',array('status'=>$status,'v'=>$v),false,false);
		?>

	
<?php endforeach; ?>