<?php
/* @var $this PersonnelPostsHistoryController */
/* @var $model PersonnelPostsHistory */

$this->breadcrumbs=array(
	'Personnel Posts Histories'=>array('index'),
	'Manage',
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
	$('#personnel-posts-history-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Кадры. Должности</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'personnel-posts-history-grid',
	'dataProvider'=>$model->search(array('criteria'=>array(
        'condition'=>'id_personnel=2'))),
	'filter'=>$model,
	'columns'=>array(
        array( 'name'=>'personnel', 'value'=>'$data->personnel->surname' ),
        array( 'name'=>'department_posts', 'value'=>'$data->department_posts->post' ),
		'date_begin',
		'date_end',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
