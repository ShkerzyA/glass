<?php
/* @var $this EquipmentLogController */
/* @var $model EquipmentLog */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверены?')),
	array('label'=>'Управление', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
);
?>

<h1>Отобразить "<?php  echo $model::$modelLabelS; ?>"  #<?php echo $model->id; ?></h1> 

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'timestamp',
		array( 'name'=>'type', 'value'=>$model->getType()["name"] ),
		array( 'name'=>'subject0subject', 'value'=>$model->subject0->fio_full()),
		array( 'name'=>'object0object', 'value'=>$res=(!empty($model->objectEq))?$model->objectEq->idWorkplace->wpNameFull().' '.$model->objectEq->full_name():''),
		array( 'name'=>'details','type'=>'html', 'value'=>$model->details_full()),
	),
)); ?>
