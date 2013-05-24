<?php
/* @var $this CabinetController */
/* @var $model Cabinet */

$this->breadcrumbs=array(
	'Кабинеты'=>array('index'),
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
	$('#cabinet-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Кабинеты</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cabinet-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array('name' => 'building' ,'value'=>'$data->building->name' ),
		'name',
		'num',
		'floor',
		'phone',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
