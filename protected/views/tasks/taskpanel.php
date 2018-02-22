
	<?php $status=$data->status0; ?>
	<div  class="taskpanel <?php echo 'hide'.$status['id']; ?> <?php echo $status['css_class']; ?> <?php echo $data->isGroovy(); ?> <?php echo $dl=(!empty($data->deadline))?' deadline ':'';?>">
			<div  class="rightinfo">
				<?php 	
						if(!empty($data->deadline)){
							echo '<img src="'.Yii::app()->request->baseUrl.'/images/clock_24.png" title="'.$data->deadline.'">';
						}
						echo'<div style="font-size: 9pt; text-align: left;">';
					
						if(!empty($data->timestamp_end)){
							echo $data->short_date('timestamp_end');
						}else{
							echo $data->short_date('timestamp');
						}
						echo'<br>';

						if(Yii::app()->user->checkAccess('taskReport',array('mod'=>$data))){
							$repcl=$data->reportInc();
							if($repcl){
								echo '<div class='.$repcl.' style="top: -3px"></div>';
							}
						}

						echo ('<div class='.$status['css_status'].' style="text-align: left">'.$status['label'].'</div>');
						echo'</div>';

						


						echo'<div class="taskmoreinfo">';
						
						$exec=$data->commExecutors();

						foreach ($exec as $z) {
							//if(method_exists($z,'ava'))
							echo '<img height=100% style="opacity: '.$z['opacity'].';'.$z['border'].'" src="'.$z['executor']->ava().'">';
						}
						
						$rep='';
				
						

						echo'</div>';
						
				?>
				
				
			</div>
			<div class="leftinfo" draggable='True'><?php echo $sta=(!empty($data->rating))?'<div class="ratingStar"><b>'.$data->rating.'</b></div>':''; ?>
				<?php echo $data->ico().'<div style="float: right; width: 92%"><a href='.Yii::app()->request->baseUrl.'/tasks/'.$data->id.'>'.Custom::deadclockwrap($data).' '.$data['tname'].' <span class=gray>'.$data->detailsShow(true).'</span></a></div>'; ?>
				
			</div>
			<div class="texttask rotated"><pre><?php echo $data->id.' '.Custom::deadclockwrap($data).' '.$data->detailsShow(False,True,True).'<br>'. $data['ttext']; ?></pre></div>
		</div>