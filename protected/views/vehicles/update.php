<?php
/* @var $this VehiclesController */
/* @var $model Vehicles */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Изменить',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Отобразить', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Управление ', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
);
	//$this->menu["details"]=array(array('label'=>'Personnel', 'url'=>array('Personnel/admin', 'owner'=>$model->id)),);
?>

<h1>Изменить <?php  echo $model->nameL() ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>