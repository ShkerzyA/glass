<?php
/* @var $this EventsController */
/* @var $model Events */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('/Rooms/show'),
	$model->name=>array('view','id'=>$model->id),
	'Изменить',
);
if(Yii::app()->user->role=='administrator'){
$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Отобразить', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Управление ', 'url'=>array('admin')),
);
	$this->menu["details"]=array(array('label'=>'DepartmentPosts', 'url'=>array('DepartmentPosts/admin', 'creator'=>$model->id)),
array('label'=>'Rooms', 'url'=>array('Rooms/admin', 'id_room'=>$model->id)),
);}
?>

<h2>Изменить событие <?php  echo($model->date.' в помещении "'.$model->idRoom->idCabinet->cname.' '.$model->idRoom->idCabinet->num); ?>"</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>