<?php
/* @var $this TasksController */
/* @var $model Tasks */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('index'),
	'Управление',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
);



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#tasks-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление  "<?php  echo $model::$modelLabelP; ?>"</h1>


<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tasks-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'tname',
		'ttext',
		'date_begin',
		'date_end',
		'type',
		/*
		array( 'name'=>'creator0creator', 'value'=>'$data->creator0->creator' ),
		array( 'name'=>'executor0executor', 'value'=>'$data->executor0->executor' ),
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
