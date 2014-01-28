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
				<?php echo $status['label']; ?>
				<?php echo $v->date_begin; ?>
			</div>
		</div>
	</a>
<?php endforeach; ?>


