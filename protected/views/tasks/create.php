<?php
/* @var $this TasksController */
/* @var $model Tasks */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('helpDesk'),
	'Создать',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index'),'visible'=>(Yii::app()->user->role=='administrator')),
	array('label'=>'Управление', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
);
?>

<h2>Добавить задачу</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>