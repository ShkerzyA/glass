
	<?php $status=$data->status0; ?>
	<div  class="taskpanel <?php echo 'hide'.$status['id']; ?> <?php echo $status['css_class']; ?> <?php echo $data->isGroovy(); ?> <?php echo $dl=(!empty($data->deadline))?' deadline ':'';?>">
			
			<div  class="rightinfo">
				<?php 	
						if(!empty($data->deadline)){
							echo '<img src="'.Yii::app()->request->baseUrl.'/images/clock_24.png" title="'.$data->deadline.'">';
						}
						echo'<div style="font-size: 9pt; text-align: left;">';
					
						if(!empty($data->timestamp_end)){
							echo $data->timestamp_end;
						}else{
							echo $data->timestamp;
						}
						echo'<br>';

						if(Yii::app()->user->checkAccess('taskReport',array('mod'=>$data))){
							$repcl=$data->reportInc();
							if($repcl){
								echo '<div class='.$repcl.' style="top: -3px"></div>';
							}
						}

						echo ('<div class='.$status['css_status'].' style="text-align: left">'.$status['label'].' <b>('.$data->id.')</b></div>');
						echo'</div>';

						


						echo'<div class="taskmoreinfo">';
						
						$exec=$data->findExecutors();

						foreach ($exec as $z) {
							//if(method_exists($z,'ava'))
							echo '<img height=100% src="'.$z->ava().'">';
						}
						

					
						//print_r($data->TasksActions[0]->creator0);
					
						$rep='';
						echo '<div class="hiddeninfotask rotated">';
						echo'<span></span>';
						
						foreach ($data->TasksActions as $action) {
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
							echo'<span>'.$action->creator0->wrapFio('fio').' ('.$action->timestamp.')</span>';

						}

						echo'</div>';
						

						echo'</div>';
						
				?>
				
				
			</div>
			<div class="leftinfo" draggable='True'>
				<?php echo $data->ico().'<div style="float: right; width: 92%"><a href=/glass/tasks/'.$data->id.'>'.Custom::deadclockwrap($data).' '.$data['tname'].' <span class=gray>'.$data->detailsShow(true).'</span></a></div>'; ?>
				
			</div>
			<div class="texttask rotated"><pre><?php echo $data->id.' '.Custom::deadclockwrap($data).' '.$data->detailsShow(False,True,True).'<br>'. $data['ttext']; ?></pre></div>
		</div>