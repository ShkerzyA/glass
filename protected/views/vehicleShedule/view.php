<?php
/* @var $this VehicleSheduleController */
/* @var $model VehicleShedule */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'visible'=>Yii::app()->user->role=='administrator','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверены?')),
	array('label'=>'Управление', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
	array('label'=>'Лог', 'url'=>'#','visible'=>(Yii::app()->user->checkAccess('inGroup',array('it'))),'linkOptions'=>array('class'=>'showlogUni','id'=>$model->id,'mod'=>get_class($model)),)
);
?>

<h1>Отобразить "<?php  echo $model::$modelLabelS; ?>"  #<?php echo $model->id; ?></h1> 

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'creator','value'=>$model->creator0->fio_full()),
		'date_begin',
		'date_end',
		'timestamp',
		'timestamp_end',
		array('name'=>'week','value'=>$model->DaysOfWeek()),
	),
)); ?>
