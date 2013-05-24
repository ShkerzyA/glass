<?php
/* @var $this CabinetController */
/* @var $model Cabinet */

$this->breadcrumbs=array(
	'Cabinets'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Cabinet', 'url'=>array('index')),
	array('label'=>'Create Cabinet', 'url'=>array('create')),
	array('label'=>'View Cabinet', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Cabinet', 'url'=>array('admin')),
);
?>

<h1>Update Cabinet <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>