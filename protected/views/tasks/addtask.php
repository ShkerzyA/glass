<div id="add_task" class="add_unit">

<a href="<?php echo(Yii::app()->request->baseUrl) ?>/tasks/create?Tasks[type]=0&&Tasks[project]=<?php echo $project->id ?>">
	добавить
	<img src='../images/add_task_40.png' title='Обычная задача'>
</a>
<?php if(!empty($project)):?>
	<?php foreach($project->tasktype as $t):?>
		<a href="<?php echo(Yii::app()->request->baseUrl) ?>/tasks/create?Tasks[type]=1&&Tasks[project]=<?php echo $project->id ?>">
			<img src='../images/printer_40.png' title='Замена картриджа'>
		</a>
	<?php endforeach; ?>
<?php endif; ?>

</div>