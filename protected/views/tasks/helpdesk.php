<?php
/* @var $this TasksController */
/* @var $model Tasks */

$date=(!empty($_GET['date']))?"&&date='".$_GET['date']."'":'';

if(!Yii::app()->user->isGuest)
if(Yii::app()->user->id_pers=='20058'){
	$num_task=count(TasksActions::model()->findAll(array('condition'=>"t.creator=".Yii::app()->user->id_pers." and t.type=2 and t.timestamp::date='".date('d.m.Y')."'")));
	$this->rightWidget[]='<br><div class=taskpanel>Выполнено задач: '.$num_task.'</div>';
}


$this->breadcrumbs=array(
);

$this->menu=array(
			array('label'=>'Персональный отчет', 'url'=>array('report?'.$date), 'linkOptions'=>array('target'=>'_blank'),'visible'=>Yii::app()->user->checkAccess('taskReport',array('mod'=>$model)),),
			array('label'=>'Отчет по отделу', 'url'=>array('reportOtd?'.$date), 'linkOptions'=>array('target'=>'_blank'),'visible'=>(Yii::app()->user->checkAccess('otdReport',array('mod'=>$model)))),
			array('label'=>'Отчет по сотрудникам отдела', 'url'=>array('reportOtd?personInfo=true'.$date), 'linkOptions'=>array('target'=>'_blank'),'visible'=>(Yii::app()->user->checkAccess('otdReport',array('mod'=>$model)))),
			array('label'=>'Картриджи/Экспорт', 'url'=>array('/equipmentLog/exportCart'), 'linkOptions'=>array('target'=>'_blank'),'visible'=>(Yii::app()->user->checkAccess('inGroup',array('group'=>'changeobjects')))),
			);

$this->menu['all_menu']=array(
		array('title'=>'Фильтры задач','items'=>array(
			array('label'=>'Актуальные', 'url'=>array('HelpDesk?id_department='.$this->id_department.'&&group='.$this->group.'&&type=1'),'items'=>array(
			array('label'=>'За сегодня', 'url'=>array('HelpDesk?id_department='.$this->id_department.'&&group='.$this->group.'&&type=3')),
		)),
	))
	);
?>
<meta http-equiv="Refresh" content="60" />
<?php foreach ($this->tasks_menu as $x): ?>

	<?php if($this->mayShow($x['rule'])): ?>
	<a href=<?php echo(Yii::app()->request->baseUrl) ?>/tasks/helpDesk?id_department=<?php echo $x['id_department'] ?>&&group=<?php echo $x['group'] ?>>
		<div class="inset2 <?php echo $cl_act=($x['id_department']==$this->id_department&&$x['group']==$this->group)?'active':''; ?>"><?php echo $x['name'] ?>
			<div class=downp></div>
		</div>
	</a>
	<?php endif; ?>
<?php endforeach; ?>


<div id="add_task" class="add_unit fl_right">
<a href="<?php echo(Yii::app()->request->baseUrl) ?>/tasks/create?Tasks[id_department]=<?php echo $this->id_department ?>&&Tasks[group]=<?php echo $this->group ?>">
	добавить
	<img src='../images/add_task_40.png' title='Обычная задача'>
</a>
<a href="<?php echo(Yii::app()->request->baseUrl) ?>/tasks/create?Tasks[id_department]=<?php echo $this->id_department ?>&&Tasks[group]=<?php echo $this->group ?>&&Tasks[type]=1">
	<img src='../images/printer_40.png' title='Замена картриджа'>
</a>
</div>
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
			<span><a href=/glass/tasks/<?php echo $v->id; ?>>
			<?php echo $v->ico(); ?>
			<?php echo $v['tname'].$v->detailsShow(true);; ?>
			</a>
			<div class="texttask rotated"><pre><?php echo $v['ttext'].$v->detailsShow(); ?></pre></div></span>
			<div  class="rightinfo">
				<?php 	
						echo'<div class="taskmoreinfo"> <img height=100% src="';
						//print_r($v->TasksActions[0]->creator0);
						if (!empty($v->TasksActions[0]->creator0->photo)){
							echo (Yii::app()->request->baseUrl.'/media'.DIRECTORY_SEPARATOR.CHtml::encode($v->TasksActions[0]->creator0->photo)); 
						}else{
							echo (Yii::app()->request->baseUrl.'/images/no_avatar.jpg');
						}
						echo "\">";
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
							echo'<span>'.$status_arr[$action->ttext].' ';
							echo' '.$action->creator0->fio().' ('.$action->timestamp.')</span>';

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


