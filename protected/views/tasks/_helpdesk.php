
<?php
if($this->isHorn)
	echo '<audio src="'.$this->horn.'" autoplay="true"></audio>';	
?>
	

<?php foreach ($model as $v): ?>

		<?php $status=$v->gimmeStatus(); 
		?>
		<div class="taskpanel <?php echo $status['css_class']; ?>">
			<span><a href=/glass/tasks/<?php echo $v->id; ?>>
			<?php echo $v->ico(); ?>
			<?php echo $v['tname'].$v->detailsShow(true);; ?>
			</a>
			<div class="texttask rotated"><pre><?php echo $v['ttext'].$v->detailsShow(); ?></pre></div></span>
			<div  class="rightinfo">
				<?php 	
						echo'<div class="taskmoreinfo">';
						if(!empty($v->TasksActions[0]->creator0)){
							echo '<img height=100% src="';
							echo $v->TasksActions[0]->creator0->ava();
							echo'">';}
						//print_r($v->TasksActions[0]->creator0);
					
						$rep='';
						echo '<div class=hiddeninfotask>';
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

						echo'<div>';

						if(!empty($v->executor0)){
							echo('('.$v->executor0->personnelPostsHistories[0]->idPersonnel->surname.' '.mb_substr($v->executor0->personnelPostsHistories[0]->idPersonnel->name,0,1,"utf8").'. '.mb_substr($v->executor0->personnelPostsHistories[0]->idPersonnel->patr,0,1,"utf8").'.)');	
						}
						if(!empty($v->timestamp_end)){
							echo '('.$v->timestamp_end.')';
						}else{
							echo '('.$v->timestamp.')';
						}
						echo'</div>';

						echo ('<div class='.$status['css_status'].'>'.$status['label'].'</div>');

						if(Yii::app()->user->checkAccess('taskReport',array('mod'=>$model))){
							$repcl=$v->reportInc();
							if($repcl){
								echo '<div class='.$repcl.'></div>';
							}
						}
						
				?>
				
			</div>
		</div>
<?php endforeach; ?>



