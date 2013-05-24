<?php
/* @var $this PersonnelPostsHistoryController */
/* @var $model PersonnelPostsHistory */

$this->breadcrumbs=array(
	'Personnel Posts Histories'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PersonnelPostsHistory', 'url'=>array('index')),
	array('label'=>'Create PersonnelPostsHistory', 'url'=>array('create')),
	array('label'=>'Update PersonnelPostsHistory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PersonnelPostsHistory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PersonnelPostsHistory', 'url'=>array('admin')),
);
?>

<h1>View PersonnelPostsHistory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'id_personnel',
		'id_post',
		'id_department',
		'date_begin',
		'date_end',
	),
)); ?>
