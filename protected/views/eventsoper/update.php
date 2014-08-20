<?php
/* @var $this EventsoperController */
/* @var $model Eventsoper */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('rooms/show'), 
	$model->id,
);

if(Yii::app()->user->role=='administrator'){
	$this->menu=array(
		array('label'=>'Список', 'url'=>array('index')),
		array('label'=>'Создать', 'url'=>array('create')),
		array('label'=>'Отобразить', 'url'=>array('view', 'id'=>$model->id)),
		array('label'=>'Управление ', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
	);
		$this->menu["details"]=array(array('label'=>'Personnel', 'url'=>array('Personnel/admin', 'creator'=>$model->id)),
	array('label'=>'Personnel', 'url'=>array('Personnel/admin', 'operator'=>$model->id)),
	array('label'=>'Personnel', 'url'=>array('Personnel/admin', 'anesthesiologist'=>$model->id)),
	array('label'=>'ListOperations', 'url'=>array('ListOperations/admin', 'operation'=>$model->id)),
	array('label'=>'Rooms', 'url'=>array('Rooms/admin', 'id_room'=>$model->id)),
	);
}

?>

<h1>Изменить <?php  echo $model::$modelLabelS; ?>  <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>