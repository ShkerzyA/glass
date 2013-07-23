<?php
/* @var $this PersonnelPostsHistoryController */
/* @var $model PersonnelPostsHistory */

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
	$('#personnel-posts-history-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление  "<?php  echo $model::$modelLabelP; ?>"</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'personnel-posts-history-grid',
	'dataProvider'=>$model->search(array('criteria'=>array(
        'condition'=>'id_personnel=2'))),
	'filter'=>$model,
	'columns'=>array(
        array( 'name'=>'idPersonnelid_personnel', 'value'=>'$data->idPersonnel->surname." ".$data->idPersonnel->name." ".$data->idPersonnel->patr' ),
        array( 'name'=>'idPostid_post', 'value'=>'$data->idPost->postSubdivRn->name."/".$data->idPost->post' ),
		'date_begin',
		'date_end',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
