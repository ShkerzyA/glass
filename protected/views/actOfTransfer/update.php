<?php
/* @var $this ActOfTransferController */
/* @var $model ActOfTransfer */

$this->breadcrumbs=array(
	$model::$modelLabelP=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Изменить',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create'),'visible'=>(Yii::app()->user->role=='administrator')),
	array('label'=>'Отобразить', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Управление ', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator'),'visible'=>(Yii::app()->user->role=='administrator')),
);
	$this->menu["details"]=array(array('label'=>'EqActsoftransfer', 'url'=>array('EqActsoftransfer/admin', 'id_act'=>$model->id),'visible'=>(Yii::app()->user->role=='administrator')),
array('label'=>'Equipment', 'url'=>array('Equipment/admin', 'id_eq'=>$model->id),'visible'=>(Yii::app()->user->role=='administrator')),
);
?>

<h1>Изменить <?php  echo $model::$modelLabelS; ?>  <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>