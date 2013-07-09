<?php
/* @var $this PersonnelPostsController */
/* @var $model PersonnelPosts */

$this->breadcrumbs=array(
	'Personnel Posts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PersonnelPosts', 'url'=>array('index')),
	array('label'=>'Create PersonnelPosts', 'url'=>array('create')),
	array('label'=>'Update PersonnelPosts', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PersonnelPosts', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PersonnelPosts', 'url'=>array('admin')),
);
?>

<h1>View PersonnelPosts #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'post',
	),
)); ?>
