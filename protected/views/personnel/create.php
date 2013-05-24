<?php
/* @var $this PersonnelController */
/* @var $model Personnel */

$this->breadcrumbs=array(
	'Personnels'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Personnel', 'url'=>array('index')),
	array('label'=>'Manage Personnel', 'url'=>array('admin')),
);
?>

<h1>Create Personnel</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>