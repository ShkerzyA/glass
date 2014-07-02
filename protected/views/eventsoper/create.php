<?php
/* @var $this EventsoperController */
/* @var $model Eventsoper */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('rooms/show'), 
	$model->id,
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index'),'visible'=>(Yii::app()->user->role=='administrator')),
	array('label'=>'Управление', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
);
?>

<h1>Создать "<?php  echo $model::$modelLabelS; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>