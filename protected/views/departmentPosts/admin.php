<?php
/* @var $this PersonnelPostsController */
/* @var $model PersonnelPosts */

$this->breadcrumbs=array(
	'Должности персонала'=>array('index'),
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
	$('#personnel-posts-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Должности персонала</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'personnel-posts-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array( 'name'=>'department', 'value'=>'$data->department->name' ),
		'post',
		'date_begin',
		'date_end',
       	
       	array( 'name'=>'personnel_posts_history[0]', 'value'=>'$data->personnel_posts_history[0]->allPersonelForPost($data->id)' ),
       	
		
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
