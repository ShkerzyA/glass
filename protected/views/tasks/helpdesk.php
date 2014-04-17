<?php
/* @var $this TasksController */
/* @var $model Tasks */

$this->breadcrumbs=array(
);

//$this->menu=array('title'=>'Фильтры','items'=>array( array('label'=>'По умолчанию', 'url'=>array('HelpDesk?id_department=1011&&type=0'))));



$this->menu['all_menu']=array(
	array('title'=>'Фильтры задач','items'=>array(
		array('label'=>'По умолчанию', 'url'=>array('HelpDesk?id_department='.$model[0]->id_department.'&&type=0'),'items'=>array(
		)),
		array('label'=>'В работе', 'url'=>array('HelpDesk?id_department='.$model[0]->id_department.'&&type=1'),'items'=>array(

			array('label'=>'За сегодня', 'url'=>array('HelpDesk?id_department='.$model[0]->id_department.'&&type=3')),
			array('label'=>'Все', 'url'=>array('HelpDesk?id_department='.$model[0]->id_department.'&&type=2')),
		)),
	))
	);


?>
<meta http-equiv="Refresh" content="60" />
<a href=<?php echo(Yii::app()->request->baseUrl) ?>/tasks/helpDesk?id_department=1012&&group=deedfdf><div class="inset">Электрики</div></a>
<a href="<?php echo(Yii::app()->request->baseUrl) ?>/tasks/create?Tasks[id_department]=1011">
<div id="add_task" class="add_unit fl_right">добавить задачу</div>
</a>
<br><br><br>

<?php foreach ($model as $v): ?>
	<a href=/glass/tasks/<?php echo $v->id; ?>>
		<?php $status=$v->gimmeStatus(); ?>
		<div class="taskpanel <?php echo $status['css_class']; ?>">
			<?php echo $v['tname']; ?>
			<div style="position: relative; float: right;">
				<?php 	echo ('<span class='.$status['css_status'].'>'.$status['label'].' </span>'); 
						if(!empty($v->executor0)){
							echo('('.$v->executor0->personnelPostsHistories[0]->idPersonnel->surname.' '.mb_substr($v->executor0->personnelPostsHistories[0]->idPersonnel->name,0,1,"utf8").'. '.mb_substr($v->executor0->personnelPostsHistories[0]->idPersonnel->patr,0,1,"utf8").'.)');	
						}
						echo ' '.$v->timestamp; 
				?>
				
			</div>
		</div>
	</a>
<?php endforeach; ?>


