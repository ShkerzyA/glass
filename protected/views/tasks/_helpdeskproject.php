<?php foreach($models as $project): ?>
	
	<tr class=prjT id= <?php echo $project->id ?> >
		<td colspan=23><div class=projectpanel> 
		<?php $this->renderPartial('addtask',array(
			'project'=>$project,
		)); 
		?>
		<div style="width: 300px; float: left">
		Проект:
		<?php print($project->name); ?> 
		</div>
		<?php $this->renderPartial('/tasks/_projectInfo',array('project'=>$project->projectInfo())); ?> <div class="taskmoreinfo"><?php
		$exec=$project->findExecutors();
		 


						foreach ($exec as $z) {
							echo '<img height=100% class="dragPers" id="'.$z->id.'" src="';
							echo $z->ava();
							echo'" title="'.$z->fio().'">';
						}
						?> </div></div>
					</td>
	</tr>
	<?php foreach($project->Tasks as $task): ?>
		<tr class=prj<?php echo $project->id ?>>
		<?php
			$all_cols=23;
			$deadline=$task->getDeadline();

			//print_r($deadline);
			if(!empty($deadline)){
				if($deadline['difdays']<0 or ($deadline['difdays']==0 and $deadline['difhours']<0)){
					if($deadline['difdays']<(-7)){
						$befor=0;
						$colspan=4;
						$after=19;
					}else if($deadline['difdays']<(-1)){
						$befor=1;
						$colspan=3;
						$after=19;
					}else{
						$befor=2;
						$colspan=2;
						$after=19;
					}
				}else{
					$befor=3;
					$colspan=1;
					$after=19;
					if($deadline['difdays']<1){
						$colspan+=$deadline['hours']-7;
						$after-=$deadline['hours']-7;
					}else if($deadline['difdays']<8){
						$colspan+=$deadline['difdays']+11;
						$after-=$deadline['difdays']+11;
					}else{
						$colspan=20;
						$after=0;
					}
				}
			}else{
				$befor=3;
				$colspan=1;
				$after=19;
			}

			echo tdEcho($befor,0);
			echo '<td colspan='.$colspan.'>';
			echo $this->renderPartial('taskpanel',array('data'=>$task),false,false).'</td>'.tdEcho($after,$befor+$colspan);

			//print_r($deadline);
			/*
			if(isset($deadline['difdays']) and $deadline['difdays']<0 or ($deadline['difdays']==0 and $deadline['difhours']<0)){
				if($deadline['difdays']<(-7)){
					echo'<td colspan=4>';
				}else if($deadline['difdays']<(-1)){
					echo tdEcho(1).'<td colspan=3';
				}else{
					echo tdEcho(2).'<td colspan=2';
				}
			}else{
				echo tdEcho(3).'<td';
			}
			 
			if(isset($deadline['difdays']) and $deadline['difdays']>=0){
				echo '>';
				echo $this->renderPartial('taskpanel',array('data'=>$task),false,false).'</td>';
				echo tdEcho(18); 
			}else{
				echo '>';
				echo $this->renderPartial('taskpanel',array('data'=>$task),false,false).'</td>';
				echo tdEcho(18); 
			} */?> 
		</tr>

	<?php endforeach; ?>



<?php endforeach; ?>