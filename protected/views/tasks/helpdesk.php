<?php
/* @var $this TasksController */
/* @var $model Tasks */

$this->breadcrumbs=array(
);

?>
<a href="/glass/tasks/create?Tasks[id_department]=1011">
<div id="add_task" class="add_unit fl_right">добавить задачу</div>
</a>
<br><br><br>

<?php foreach ($model as $v): ?>
	<a href=/glass/tasks/<?php echo $v->id; ?>>
		<?php $status=$v->gimmeStatus(); ?>
		<div class="taskpanel <?php echo $status['css_class']; ?>">
			<?php echo $v['tname']; ?>
			<div style="position: relative; float: right;">
				<?php 	echo $status['label'].' '; 
						if(!empty($v->executor0)){
							echo('('.$v->executor0->personnelPostsHistories[0]->idPersonnel->surname.' '.mb_substr($v->executor0->personnelPostsHistories[0]->idPersonnel->name,0,1,"utf8").'. '.mb_substr($v->executor0->personnelPostsHistories[0]->idPersonnel->patr,0,1,"utf8").'.)');	
						}
						echo ' '.$v->date_begin; 
				?>
				
			</div>
		</div>
	</a>
<?php endforeach; ?>


