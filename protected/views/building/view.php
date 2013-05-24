<?php
/* @var $this BuildingController */
/* @var $model Building */

$this->breadcrumbs=array(
	'Buildings'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Building', 'url'=>array('index')),
	array('label'=>'Create Building', 'url'=>array('create')),
	array('label'=>'Update Building', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Building', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Building', 'url'=>array('admin')),
);
?>

<h1>View Building #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'adress',
	),
)); ?>
