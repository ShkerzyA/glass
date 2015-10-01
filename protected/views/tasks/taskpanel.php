	<?php $status=$v->gimmeStatus(); ?>
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

						if(Yii::app()->user->checkAccess('taskReport',array('mod'=>$v))){
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
						echo '<div class="hiddeninfotask rotated">';
						echo'<span></span>';
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

						echo'</div>';
						

						echo'</div>';
						
				?>
				
				
			</div>
			<div class="leftinfo">
				<?php echo $v->ico().'<a href=/glass/tasks/'.$v->id.'>'.$v['tname'].' <span class=gray>'.$v->detailsShow(true).'</span></a>'; ?>
			
				
			</div>
			<div class="texttask rotated"><pre><?php echo $v->detailsShow(False,True,True).'<br>'. $v['ttext']; ?></pre></div>
		</div>