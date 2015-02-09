
<?php
if($this->isHorn){
	echo '<audio src="'.$this->horn.'" autoplay="true"></audio>';	
	echo '<script>notifyUser("Задачи","Новая задача");</script>';
}
?>
	

<?php foreach ($model as $v): ?>

		<?php $status=$v->gimmeStatus(); 
		?>
		<div class="taskpanel <?php echo $status['css_class']; ?>">
			
			<div  class="rightinfo">
				<?php 	
						
						echo'<div style="font-size: 9pt; text-align: left;">';
					
						if(!empty($v->timestamp_end)){
							echo $v->timestamp_end;
						}else{
							echo $v->timestamp;
						}
						echo'<br>';

						if(Yii::app()->user->checkAccess('taskReport',array('mod'=>$model))){
							$repcl=$v->reportInc();
							if($repcl){
								echo '<div class='.$repcl.' style="top: -3px"></div>';
							}
						}

						echo ('<div class='.$status['css_status'].' style="text-align: left">'.$status['label'].'</div>');

						echo'</div>';

						


						echo'<div class="taskmoreinfo">';

						$exec=$v->findExecutors();

						foreach ($exec as $z) {
							echo '<img height=100% src="';
							echo $z->ava();
							echo'">';
						}
						

					
						//print_r($v->TasksActions[0]->creator0);
					
						$rep='';
						echo '<div class="hiddeninfotask rotated texttask">';
						foreach ($v->TasksActions as $action) {
							if($action->type==1)
								continue;
							if($action->type==2){
								$rep='<img style="max-height: 20px" src='.Yii::app()->request->baseUrl.'/images/doc.png>';
								$id_pers=(!empty(Yii::app()->user->id_pers))?Yii::app()->user->id_pers:NULL;
								if($action->creator==$id_pers){
									$rep='<img style="max-height: 20px" src='.Yii::app()->request->baseUrl.'/images/doc_gold.png>';
									break;
								}
							}
							echo'<span>'.$action->creator0->fio().' ('.$action->timestamp.')</span>';

						}

						echo'<span></span></div>';
						

						echo'</div>';
						
				?>
				
				
			</div>
			<span>

			<?php echo '<div style="float: left; width: auto; overflow: hidden">'.$v->ico().'<a href=/glass/tasks/'.$v->id.'>'.$v['tname'].$v->detailsShow(true).'</a></div>'; ?>
			
			<div class="texttask rotated"><pre><?php echo $v['ttext'].$v->detailsShow(); ?></pre></div></span>
		</div>
<?php endforeach; ?>



