<?php
/* @var $this PersonnelController */
/* @var $model Personnel */

$this->breadcrumbs=array(
	'Personnels'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Personnel', 'url'=>array('index')),
	array('label'=>'Create Personnel', 'url'=>array('create')),
	array('label'=>'View Personnel', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Personnel', 'url'=>array('admin')),
	array('label'=>'Должности', 'url'=>array('PersonnelPostsHistory/admin', 'id_personnel'=>$model->id)),
);


?>

<h1>Сотрудник <u><?php echo ($model->surname.' '.$model->name.' '.$model->patr); ?></u></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>