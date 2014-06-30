<?php
/* @var $this EventsoperController */
/* @var $model Eventsoper */

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
	$('#eventsoper-grid').yiiGridView('update', {
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
	'id'=>'eventsoper-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array( 'name'=>'idRoomid_room', 'value'=>'$data->idRoom->id_room' ),
		'date',
		'timestamp',
		'timestamp_end',
		'fio_pac',
		/*
		array( 'name'=>'creator0creator', 'value'=>'$data->creator0->creator' ),
		array( 'name'=>'operator0operator', 'value'=>'$data->operator0->operator' ),
		'date_gosp',
		'brigade',
		array( 'name'=>'anesthesiologist0anesthesiologist', 'value'=>'$data->anesthesiologist0->anesthesiologist' ),
		array( 'name'=>'operation0operation', 'value'=>'$data->operation0->operation' ),
		'type_operation',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
