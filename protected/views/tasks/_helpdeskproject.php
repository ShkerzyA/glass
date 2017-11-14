<?php foreach($models as $project): ?>
	
	<tr class=prjT id= <?php echo $project->id ?> >
		<td colspan=23><div class=projectpanel> 
		<?php $this->renderPartial('addtask',array(
			'project'=>$project,
		)); 
		?>
		<div class=projecttitle>
		Проект:
		<?php echo$project->name; ?> 
		<div>
			<?php echo $project->description ?>
		</div>
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
		<tr class=prj<?php echo $project->id ?> style="display: none";>
		<?php
			$all_cols=23;
			$deadline=$task->getDeadline();
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
					if($deadline['difdays']<1 and $deadline['hours']>7){
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
			?> 
		</tr>

	<?php endforeach; ?>



<?php endforeach; ?>