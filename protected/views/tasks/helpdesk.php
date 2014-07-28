<?php
/* @var $this TasksController */
/* @var $model Tasks */

$this->breadcrumbs=array(
);

$this->menu=array(
			array('label'=>'Персональный отчет', 'url'=>array('report'), 'linkOptions'=>array('target'=>'_blank'),'visible'=>Yii::app()->user->checkAccess('taskReport',array('mod'=>$model)),),
			array('label'=>'Отчет по отделу', 'url'=>array('reportOtd'), 'linkOptions'=>array('target'=>'_blank'),'visible'=>(Yii::app()->user->checkAccess('otdReport',array('mod'=>$model)))),
			array('label'=>'Отчет по сотрудникам отдела', 'url'=>array('reportOtd?personInfo=true'), 'linkOptions'=>array('target'=>'_blank'),'visible'=>(Yii::app()->user->checkAccess('otdReport',array('mod'=>$model)))),
			);

$this->menu['all_menu']=array(
	array('title'=>'Фильтры задач','items'=>array(
		array('label'=>'По умолчанию', 'url'=>array('HelpDesk?id_department='.$this->id_department.'&&group='.$this->group.'&&type=0'),'items'=>array(
		)),
		array('label'=>'В работе', 'url'=>array('HelpDesk?id_department='.$this->id_department.'&&group='.$this->group.'&&type=1'),'items'=>array(

			array('label'=>'За сегодня', 'url'=>array('HelpDesk?id_department='.$this->id_department.'&&group='.$this->group.'&&type=3')),
			array('label'=>'Все', 'url'=>array('HelpDesk?id_department='.$this->id_department.'&&group='.$this->group.'&&type=2')),
		)),
	))
	);
?>
<meta http-equiv="Refresh" content="60" />
<?php foreach ($this->tasks_menu as $x): ?>

	<a href=<?php echo(Yii::app()->request->baseUrl) ?>/tasks/helpDesk?id_department=<?php echo $x['id_department'] ?>&&group=<?php echo $x['group'] ?>>
		<div class="inset2 <?php echo $cl_act=($x['id_department']==$this->id_department&&$x['group']==$this->group)?'active':''; ?>"><?php echo $x['name'] ?>
			<div class=downp></div>
		</div>
	</a>
<?php endforeach; ?>

<a href="<?php echo(Yii::app()->request->baseUrl) ?>/tasks/create?Tasks[id_department]=<?php echo $this->id_department ?>&&Tasks[group]=<?php echo $this->group ?>">
<div id="add_task" class="add_unit fl_right">добавить задачу</div>
</a>
<br><br><br>


<?php
if(!empty($model)){
	$status_arr=$model[0]->getStatus(); 	
}
if($this->isHorn)
	echo '<audio src="'.$this->horn.'" autoplay="true"></audio>';	
?>

<?php foreach ($model as $v): ?>

		<?php $status=$v->gimmeStatus(); 
		?>
		<div class="taskpanel <?php echo $status['css_class']; ?>">
			<a href=/glass/tasks/<?php echo $v->id; ?>>
			<?php echo $v['tname']; ?>
			</a>
			<div style="position: relative; float: right;">
				<?php 	echo ('<span class='.$status['css_status'].'>'.$status['label']);

						echo'<div class="taskmoreinfo"> <img height=100% src="';
						if (!empty($v->TasksActions[0]->creator0->photo)){
							echo (Yii::app()->request->baseUrl.'/media'.DIRECTORY_SEPARATOR.CHtml::encode($v->TasksActions[0]->creator0->photo)); 
						}else{
							echo (Yii::app()->request->baseUrl.'/images/no_avatar.jpg');
						}
						echo "\">";
						$rep='';
						echo '<div class=hiddeninfotask style="float: rigth;">';
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
							echo'<span><nobr>'.$status_arr[$action->ttext].' ';
							echo' '.$action->creator0->surname.' '.mb_substr($action->creator0->name,0,1,'UTF-8').'. '.mb_substr($action->creator0->patr,0,1,'UTF-8').'. ('.$action->timestamp.')</nobr></span><br>';

						}

						echo'</div>';
						

						echo'</div>';

						if(Yii::app()->user->checkAccess('taskReport',array('mod'=>$model))){
							$repcl=$v->reportInc();
							if($repcl){
								echo '<div class='.$repcl.'></div>';
							}
						}
						
						


						echo' </span>'; 
						if(!empty($v->executor0)){
							echo('('.$v->executor0->personnelPostsHistories[0]->idPersonnel->surname.' '.mb_substr($v->executor0->personnelPostsHistories[0]->idPersonnel->name,0,1,"utf8").'. '.mb_substr($v->executor0->personnelPostsHistories[0]->idPersonnel->patr,0,1,"utf8").'.)');	
						}
						if(!empty($v->timestamp_end)){
							echo '('.$v->timestamp_end.')';
						}else{
							echo '('.$v->timestamp.')';
						}
						
				?>
				
			</div>
		</div>
<?php endforeach; ?>


