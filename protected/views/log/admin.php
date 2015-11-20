<?php
/* @var $this LogController */
/* @var $model Log */

$this->breadcrumbs=array(
	'Администрирование'=>array('/admin/index'),
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
	$('#log-grid').yiiGridView('update', {
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
	'id'=>'log-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'timestamp',
		array( 'name'=>'subject0subject', 'value'=>'$data->subject0->fio()' ),
		array('name'=>'object0object','value'=>'$x=(!empty($data->object))?$data->object->nameL():"нет связи"'),
		'object_model',
		'object_id',
		array('name'=>'type','value'=>'$data->getType()["name"]','filter'=>$model->filterType() ),
		'details',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
